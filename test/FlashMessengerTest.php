<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger;

use Dot\FlashMessenger\Exception\InvalidArgumentException;
use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\FlashMessengerInterface;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

class FlashMessengerTest extends TestCase
{
    use CommonTrait;

    protected FlashMessenger $subject;

    public function setUp(): void
    {
        $this->subject = new FlashMessenger($this->config['dot_flashmessenger']['options']);
    }

    /**
     * @throws Exception
     */
    public function testGettersAndSetters(): void
    {
        $namespace        = 'test_namespace';
        $sessionManager   = $this->createMock(ManagerInterface::class);
        $sessionContainer = $this->createMock(Container::class);

        $this->subject->setNamespace($namespace);
        $this->subject->setSessionManager($sessionManager);
        $this->subject->setSessionContainer($sessionContainer);

        $this->assertSame($namespace, $this->subject->getNamespace());
        $this->assertSame($sessionManager, $this->subject->getSessionManager());
        $this->assertSame($sessionContainer, $this->subject->getSessionContainer());
    }

    public function testAddMessageRaisesExceptionForInvalidMessageFormat(): void
    {
        $invalidMessage = ['Invalid array format' => ['Invalid Key' => 'Invalid value']];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Flash message must be a string or an array of strings');
        $this->subject->addMessage('error', $invalidMessage);
    }

    public function testMessageAddingAndRetrieval(): void
    {
        $this->subject->addInfo('info message', 'success-channel');
        $this->subject->addSuccess('success message', 'success-channel');
        $this->subject->addWarning(['warning message'], 'error-channel');
        $this->subject->addError(['first error message', 'second error message'], 'error-channel');

        $ref              = new ReflectionObject($this->subject);
        $container        = $ref->getProperty('sessionContainer');
        $sessionContainer = $container->getValue($this->subject);

        $messages = $sessionContainer->messages;

        $this->assertArrayHasKey('success-channel', $messages);
        $this->assertArrayHasKey('error-channel', $messages);
        $this->assertArrayHasKey(FlashMessengerInterface::INFO, $messages['success-channel']);
        $this->assertArrayHasKey(FlashMessengerInterface::SUCCESS, $messages['success-channel']);
        $this->assertArrayHasKey(FlashMessengerInterface::WARNING, $messages['error-channel']);
        $this->assertArrayHasKey(FlashMessengerInterface::ERROR, $messages['error-channel']);
        $this->assertContains('info message', $messages['success-channel'][FlashMessengerInterface::INFO]);
        $this->assertContains('success message', $messages['success-channel'][FlashMessengerInterface::SUCCESS]);
        $this->assertContains('warning message', $messages['error-channel'][FlashMessengerInterface::WARNING]);
        $this->assertContains('first error message', $messages['error-channel'][FlashMessengerInterface::ERROR]);

        //move messages from Session to FlashMessenger
        $this->subject->init();

        $successMessages = $this->subject->getMessages(null, 'success-channel');
        $errorMessages   = $this->subject->getMessages(null, 'error-channel');
        $this->assertArrayHasKey(FlashMessengerInterface::INFO, $successMessages);
        $this->assertArrayHasKey(FlashMessengerInterface::SUCCESS, $successMessages);
        $this->assertArrayHasKey(FlashMessengerInterface::WARNING, $errorMessages);
        $this->assertArrayHasKey(FlashMessengerInterface::ERROR, $errorMessages);
        $this->assertContains('info message', $successMessages[FlashMessengerInterface::INFO]);
        $this->assertContains('success message', $successMessages[FlashMessengerInterface::SUCCESS]);
        $this->assertContains('warning message', $errorMessages[FlashMessengerInterface::WARNING]);
        $this->assertContains('first error message', $errorMessages[FlashMessengerInterface::ERROR]);

        $this->assertContains(
            'info message',
            $this->subject->getMessages(FlashMessengerInterface::INFO, 'success-channel')
        );
    }

    public function testDataAddingAndRetrieval(): void
    {
        $this->subject->addData('test key', 'test data');

        $ref              = new ReflectionObject($this->subject);
        $container        = $ref->getProperty('sessionContainer');
        $sessionContainer = $container->getValue($this->subject);

        $sessionData = $sessionContainer->data;

        $this->assertArrayHasKey(FlashMessengerInterface::DEFAULT_CHANNEL, $sessionData);
        $this->assertContains('test data', $sessionData[FlashMessengerInterface::DEFAULT_CHANNEL]);

        //move data from Session to FlashMessenger
        $this->subject->init();

        $data = $this->subject->getData('test key');
        $this->assertSame('test data', $data);
    }
}
