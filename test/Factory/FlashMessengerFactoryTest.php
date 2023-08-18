<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Factory;

use Dot\FlashMessenger\Exception\RuntimeException;
use Dot\FlashMessenger\Factory\FlashMessengerFactory;
use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use DotTest\FlashMessenger\CommonTrait;
use Laminas\Session\ManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FlashMessengerFactoryTest extends TestCase
{
    use CommonTrait;

    protected ContainerInterface|MockObject $container;
    protected FlashMessengerOptions|MockObject $options;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->options   = $this->createMock(FlashMessengerOptions::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testCreateFlashMessengerWithFoundSessionManager(): void
    {
        $managerInterface = $this->createMock(ManagerInterface::class);
        $this->options->expects($this->once())
            ->method('getOptions')
            ->willReturn($this->config['dot_flashmessenger']['options']);

        $this->container->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap([
                [FlashMessengerOptions::class, $this->options],
                [$this->config['dot_flashmessenger']['options']['session_manager'], $managerInterface],
            ]);

        $this->container->expects($this->once())
            ->method('has')
            ->willReturn(true);

        $result = (new FlashMessengerFactory())($this->container, FlashMessenger::class);

        $this->assertInstanceOf(FlashMessenger::class, $result);
        $this->assertSame('dot_messenger', $result->getNamespace());
        $this->assertSame($managerInterface, $result->getSessionManager());
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testCreateFlashMessengerWithSessionManagerClass(): void
    {
        $this->options->expects($this->once())
            ->method('getOptions')
            ->willReturn($this->config['dot_flashmessenger']['options']);

        $this->container->expects($this->once())
            ->method('get')
            ->willReturn($this->options);

        $this->container->expects($this->once())
            ->method('has')
            ->willReturn(false);

        $result = (new FlashMessengerFactory())($this->container, FlashMessenger::class);

        $this->assertInstanceOf(FlashMessenger::class, $result);
        $this->assertSame('dot_messenger', $result->getNamespace());
        $this->assertInstanceOf(
            $this->config['dot_flashmessenger']['options']['session_manager'],
            $result->getSessionManager()
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testCreateFlashMessengerWithDefaultSessionManager(): void
    {
        $managerInterface = $this->createMock(ManagerInterface::class);
        $this->options->expects($this->once())
            ->method('getOptions')
            ->willReturn(['namespace' => 'test_namespace']);

        $this->container->expects($this->once())
            ->method('has')
            ->willReturn(true);

        $this->container->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap([
                [FlashMessengerOptions::class, $this->options],
                [ManagerInterface::class, $managerInterface],
            ]);

        $result = (new FlashMessengerFactory())($this->container, FlashMessenger::class);

        $this->assertInstanceOf(FlashMessenger::class, $result);
        $this->assertSame('test_namespace', $result->getNamespace());
        $this->assertInstanceOf(ManagerInterface::class, $result->getSessionManager());
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testFlashMessengerNotCreatedWithoutNamespace(): void
    {
        $this->options->expects($this->once())
            ->method('getOptions')
            ->willReturn(['namespace' => ['invalid namespace format']]);

        $this->container->expects($this->once())
            ->method('get')
            ->willReturn($this->options);

        $this->container->expects($this->once())
            ->method('has')
            ->willReturn(false);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Flash messenger need a namespace to be set');

        (new FlashMessengerFactory())($this->container, FlashMessenger::class);
    }
}
