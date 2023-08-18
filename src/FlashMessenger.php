<?php

declare(strict_types=1);

namespace Dot\FlashMessenger;

use Dot\FlashMessenger\Exception\InvalidArgumentException;
use Dot\FlashMessenger\Exception\RuntimeException;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;

use function is_string;

class FlashMessenger implements FlashMessengerInterface
{
    protected string $namespace = '';

    protected ?ManagerInterface $sessionManager = null;

    protected ?Container $sessionContainer = null;

    protected array $messages = [];

    protected array $data = [];

    public function __construct(array $options = [])
    {
        if (isset($options['namespace']) && is_string($options['namespace'])) {
            $this->setNamespace($options['namespace']);
        } else {
            throw new RuntimeException('Flash messenger need a namespace to be set');
        }

        if (isset($options['session_manager']) && $options['session_manager'] instanceof ManagerInterface) {
            $this->setSessionManager($options['session_manager']);
        }

        $this->init();
    }

    /**
     * Initialize the messenger with the previous session messages
     */
    public function init(): void
    {
        $container = $this->getSessionContainer();
        //get the messages and data that was set in the previous request
        //clear them afterwards
        if (isset($container->messages)) {
            $this->messages = $container->messages;
            unset($container->messages);
        }

        if (isset($container->data)) {
            $this->data = $container->data;
            unset($container->data);
        }
    }

    public function getSessionContainer(): Container
    {
        if (! $this->sessionContainer) {
            $this->sessionContainer = new Container($this->namespace, $this->getSessionManager());
            //start the session if not started already
            $this->sessionContainer->getManager()->start();
        }
        return $this->sessionContainer;
    }

    public function setSessionContainer(Container $container): void
    {
        $this->sessionContainer = $container;
    }

    public function getSessionManager(): ManagerInterface
    {
        if (! $this->sessionManager) {
            $this->sessionManager = new SessionManager();
        }
        return $this->sessionManager;
    }

    public function setSessionManager(ManagerInterface $sessionManager): void
    {
        $this->sessionManager = $sessionManager;
    }

    public function addData(
        string $key,
        mixed $value,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): void {
        $container = $this->getSessionContainer();
        if (! isset($container->data)) {
            $container->data = [];
        }

        if (! isset($container->data[$channel])) {
            $container->data[$channel] = [];
        }

        $container->data[$channel][$key] = $value;
    }

    public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): mixed
    {
        return isset($this->data[$channel]) ? $this->data[$channel][$key] ?? null : null;
    }

    public function getMessages(
        ?string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): array {
        if (! $type) {
            return $this->messages[$channel] ?? [];
        }

        //If the key exists then return all messages or empty array
        return isset($this->messages[$channel]) ? $this->messages[$channel][$type] ?? [] : [];
    }

    public function addMessage(
        string $type,
        string|array $message,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): void {
        $container = $this->getSessionContainer();
        if (! isset($container->messages)) {
            $container->messages = [];
        }

        if (! isset($container->messages[$channel])) {
            $container->messages[$channel] = [];
        }

        if (! isset($container->messages[$channel][$type])) {
            $container->messages[$channel][$type] = [];
        }

        $message = (array) $message;
        foreach ($message as $msg) {
            if (! is_string($msg)) {
                throw new InvalidArgumentException('Flash message must be a string or an array of strings');
            }
            $container->messages[$channel][$type][] = $msg;
        }
    }

    public function addError(string|array $error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
    {
        $this->addMessage(FlashMessengerInterface::ERROR, $error, $channel);
    }

    public function addWarning(string|array $warning, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
    {
        $this->addMessage(FlashMessengerInterface::WARNING, $warning, $channel);
    }

    public function addInfo(string|array $info, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
    {
        $this->addMessage(FlashMessengerInterface::INFO, $info, $channel);
    }

    public function addSuccess(string|array $success, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
    {
        $this->addMessage(FlashMessengerInterface::SUCCESS, $success, $channel);
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }
}
