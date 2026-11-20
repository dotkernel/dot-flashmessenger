<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger;

use Dot\FlashMessenger\Exception\InvalidArgumentException;
use Dot\FlashMessenger\Exception\RuntimeException;
use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\FlashMessengerInterface;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FlashMessengerTest extends TestCase
{
    use CommonTrait;

    private SessionManager $sessionManager;

    protected function setUp(): void
    {
        $this->sessionManager = $this->createSessionManager();
    }

    /**
     * Each call is one request: a new messenger on the same session.
     */
    private function nextRequest(string $namespace = 'dot_messenger'): FlashMessenger
    {
        return new FlashMessenger(['namespace' => $namespace, 'session_manager' => $this->sessionManager]);
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function invalidNamespaceProvider(): iterable
    {
        yield 'missing'   => [[]];
        yield 'not text'  => [['namespace' => ['dot_messenger']]];
        yield 'empty'     => [['namespace' => '']];
    }

    /**
     * @param array<string, mixed> $options
     */
    #[DataProvider('invalidNamespaceProvider')]
    public function testConstructorRequiresNamespace(array $options): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The flash messenger needs a namespace.');

        new FlashMessenger($options);
    }

    public function testGettersAndSetters(): void
    {
        $subject          = $this->nextRequest();
        $sessionManager   = $this->createStub(ManagerInterface::class);
        $sessionContainer = $this->createStub(Container::class);

        $subject->setNamespace('test_namespace');
        $subject->setSessionManager($sessionManager);
        $subject->setSessionContainer($sessionContainer);

        $this->assertSame('test_namespace', $subject->getNamespace());
        $this->assertSame($sessionManager, $subject->getSessionManager());
        $this->assertSame($sessionContainer, $subject->getSessionContainer());
    }

    public function testMessagesAreAvailableOnlyInTheNextRequest(): void
    {
        $first = $this->nextRequest();
        $first->addInfo('info message', 'success-channel');
        $first->addSuccess('success message', 'success-channel');
        $first->addWarning(['warning message'], 'error-channel');
        $first->addError(['first error message', 'second error message'], 'error-channel');

        $this->assertSame([], $first->getMessages(null, 'success-channel'));

        $second = $this->nextRequest();
        $this->assertSame(
            [
                FlashMessengerInterface::INFO    => ['info message'],
                FlashMessengerInterface::SUCCESS => ['success message'],
            ],
            $second->getMessages(null, 'success-channel')
        );
        $this->assertSame(
            ['first error message', 'second error message'],
            $second->getMessages(FlashMessengerInterface::ERROR, 'error-channel')
        );
        $this->assertSame(['warning message'], $second->getMessages(FlashMessengerInterface::WARNING, 'error-channel'));

        $this->assertSame([], $this->nextRequest()->getMessages(null, 'error-channel'));
    }

    public function testMessagesUseTheDefaultChannel(): void
    {
        $this->nextRequest()->addMessage('custom', 'custom message');

        $this->assertSame(['custom' => ['custom message']], $this->nextRequest()->getMessages());
    }

    public function testDataIsAvailableOnlyInTheNextRequest(): void
    {
        $first = $this->nextRequest();
        $first->addData('test key', ['test' => 'data']);
        $first->addData('other key', 5, 'other-channel');
        $this->assertNull($first->getData('test key'));

        $second = $this->nextRequest();
        $this->assertSame(['test' => 'data'], $second->getData('test key'));
        $this->assertSame(5, $second->getData('other key', 'other-channel'));
        $this->assertNull($second->getData('missing key'));
        $this->assertNull($second->getData('test key', 'missing-channel'));

        $this->assertNull($this->nextRequest()->getData('test key'));
    }

    /**
     * @return iterable<string, array{array<mixed>}>
     */
    public static function invalidMessageProvider(): iterable
    {
        yield 'nested array'          => [['key' => ['nested']]];
        yield 'valid then an integer' => [['valid message', 5]];
    }

    /**
     * @param array<mixed> $message
     */
    #[DataProvider('invalidMessageProvider')]
    public function testAddMessageRejectsAndWritesNothing(array $message): void
    {
        try {
            $this->nextRequest()->addError($message);
            $this->fail('An InvalidArgumentException was expected.');
        } catch (InvalidArgumentException $exception) {
            $this->assertSame('Flash message must be a string or an array of strings', $exception->getMessage());
        }

        $this->assertSame([], $this->nextRequest()->getMessages(FlashMessengerInterface::ERROR));
    }

    public function testSetNamespaceUsesANewSessionContainer(): void
    {
        $subject = $this->nextRequest('old');
        $subject->setNamespace('new');
        $subject->addError('message in the new namespace');

        $this->assertSame('new', $subject->getSessionContainer()->getName());
        $this->assertSame(['message in the new namespace'], $this->nextRequest('new')->getMessages('error'));
        $this->assertSame([], $this->nextRequest('old')->getMessages('error'));
    }

    public function testEmptyTypeReturnsNoMessages(): void
    {
        $this->nextRequest()->addError('error message');

        $this->assertSame([], $this->nextRequest()->getMessages(''));
    }

    public function testInitKeepsOnlyStringMessagesFromTheSession(): void
    {
        $container = new Container('dot_messenger', $this->sessionManager);
        $container->offsetSet('messages', [
            'channel' => ['error' => ['kept', 5, ['nested']], 'info' => 'not a list'],
            'broken'  => 'not an array',
        ]);
        $container->offsetSet('data', 'not an array');

        $subject = $this->nextRequest();

        $this->assertSame(['error' => ['kept']], $subject->getMessages(null, 'channel'));
        $this->assertSame([], $subject->getMessages(null, 'broken'));
        $this->assertNull($subject->getData('any'));
    }
}
