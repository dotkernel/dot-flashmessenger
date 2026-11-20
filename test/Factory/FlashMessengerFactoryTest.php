<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Factory;

use Dot\FlashMessenger\Exception\RuntimeException;
use Dot\FlashMessenger\Factory\FlashMessengerFactory;
use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use DotTest\FlashMessenger\CommonTrait;
use DotTest\FlashMessenger\Fixture\InMemoryContainer;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class FlashMessengerFactoryTest extends TestCase
{
    use CommonTrait;

    /**
     * @param array<string, mixed> $options
     * @param array<string, mixed> $services
     */
    private function createContainer(array $options, array $services = []): InMemoryContainer
    {
        return new InMemoryContainer(
            [FlashMessengerOptions::class => new FlashMessengerOptions(['options' => $options])] + $services
        );
    }

    public function testSessionManagerFromNamedContainerService(): void
    {
        $sessionManager = $this->createSessionManager();
        $container      = $this->createContainer(
            ['namespace' => 'dot_messenger', 'session_manager' => 'app.session'],
            ['app.session' => $sessionManager]
        );

        $result = (new FlashMessengerFactory())($container);

        $this->assertSame('dot_messenger', $result->getNamespace());
        $this->assertSame($sessionManager, $result->getSessionManager());
    }

    public function testSessionManagerFromClassName(): void
    {
        $container = $this->createContainer($this->config['dot_flashmessenger']['options']);

        $result = (new FlashMessengerFactory())($container);

        $this->assertInstanceOf(SessionManager::class, $result->getSessionManager());
    }

    public function testSessionManagerFromManagerInterfaceService(): void
    {
        $sessionManager = $this->createSessionManager();
        $container      = $this->createContainer(
            ['namespace' => 'test_namespace'],
            [ManagerInterface::class => $sessionManager]
        );

        $result = (new FlashMessengerFactory())($container);

        $this->assertSame('test_namespace', $result->getNamespace());
        $this->assertSame($sessionManager, $result->getSessionManager());
    }

    public function testFactoryIgnoresTheRequestedName(): void
    {
        $container = $this->createContainer(
            ['namespace' => 'dot_messenger'],
            [ManagerInterface::class => $this->createSessionManager()]
        );

        $result = (new FlashMessengerFactory())($container, 'FlashMessenger');

        $this->assertSame(FlashMessenger::class, $result::class);
    }

    /**
     * @return iterable<string, array{string, array<string, mixed>, string}>
     */
    public static function invalidSessionManagerProvider(): iterable
    {
        yield 'unknown name' => ['Does\\Not\\Exist', [], 'is not a container service and not a class'];
        yield 'class that is not a session manager' => [
            stdClass::class,
            [],
            'is not a container service and not a class',
        ];
        yield 'service that is not a session manager' => [
            'app.session',
            ['app.session' => new stdClass()],
            'The container returned stdClass',
        ];
    }

    /**
     * @param array<string, mixed> $services
     */
    #[DataProvider('invalidSessionManagerProvider')]
    public function testInvalidSessionManagerThrows(string $name, array $services, string $message): void
    {
        $container = $this->createContainer(['namespace' => 'dot_messenger', 'session_manager' => $name], $services);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($message);

        (new FlashMessengerFactory())($container);
    }

    public function testInvalidOptionsServiceThrows(): void
    {
        $container = new InMemoryContainer([FlashMessengerOptions::class => new stdClass()]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('is not valid');

        (new FlashMessengerFactory())($container);
    }

    public function testMissingNamespaceThrows(): void
    {
        $container = $this->createContainer(['namespace' => ['invalid namespace format']]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The flash messenger needs a namespace.');

        (new FlashMessengerFactory())($container);
    }
}
