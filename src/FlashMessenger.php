<?php

declare(strict_types=1);

namespace Dot\FlashMessenger;

use Dot\FlashMessenger\Exception\InvalidArgumentException;
use Dot\FlashMessenger\Exception\RuntimeException;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;

use function is_array;
use function is_string;

class FlashMessenger implements FlashMessengerInterface
{
    private const KEY_MESSAGES = 'messages';
    private const KEY_DATA     = 'data';

    protected string $namespace = '';

    protected ?ManagerInterface $sessionManager = null;

    /** @var Container<string, mixed>|null */
    protected ?Container $sessionContainer = null;

    /** @var array<array-key, array<array-key, list<string>>> */
    protected array $messages = [];

    /** @var array<array-key, mixed> */
    protected array $data = [];

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options = [])
    {
        if (! isset($options['namespace']) || ! is_string($options['namespace']) || $options['namespace'] === '') {
            throw new RuntimeException('The flash messenger needs a namespace.');
        }
        $this->setNamespace($options['namespace']);

        if (isset($options['session_manager']) && $options['session_manager'] instanceof ManagerInterface) {
            $this->setSessionManager($options['session_manager']);
        }

        $this->init();
    }

    /**
     * Move the messages and the data of the previous request from the session into this object.
     */
    public function init(): void
    {
        $container = $this->getSessionContainer();

        $this->messages = $this->readMessages($container->offsetGet(self::KEY_MESSAGES));
        $container->offsetUnset(self::KEY_MESSAGES);

        $data = $container->offsetGet(self::KEY_DATA);
        if (is_array($data)) {
            $this->data = $data;
        }
        $container->offsetUnset(self::KEY_DATA);
    }

    /**
     * Keep only the string messages. The session can hold values that this class did not write.
     *
     * @return array<array-key, array<array-key, list<string>>>
     */
    private function readMessages(mixed $stored): array
    {
        $messages = [];
        if (! is_array($stored)) {
            return $messages;
        }

        foreach ($stored as $channel => $types) {
            if (! is_array($types)) {
                continue;
            }
            foreach ($types as $type => $list) {
                if (! is_array($list)) {
                    continue;
                }
                foreach ($list as $message) {
                    if (is_string($message)) {
                        $messages[$channel][$type][] = $message;
                    }
                }
            }
        }

        return $messages;
    }

    /**
     * @return Container<string, mixed>
     */
    public function getSessionContainer(): Container
    {
        if ($this->sessionContainer === null) {
            $this->sessionContainer = new Container($this->namespace, $this->getSessionManager());
            $this->sessionContainer->getManager()->start();
        }

        return $this->sessionContainer;
    }

    /**
     * @param Container<string, mixed> $container
     */
    public function setSessionContainer(Container $container): void
    {
        $this->sessionContainer = $container;
    }

    public function getSessionManager(): ManagerInterface
    {
        if ($this->sessionManager === null) {
            $this->sessionManager = new SessionManager();
        }

        return $this->sessionManager;
    }

    public function setSessionManager(ManagerInterface $sessionManager): void
    {
        $this->sessionManager   = $sessionManager;
        $this->sessionContainer = null;
    }

    public function addData(
        string $key,
        mixed $value,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): void {
        $container = $this->getSessionContainer();

        $data = $container->offsetGet(self::KEY_DATA);
        if (! is_array($data)) {
            $data = [];
        }
        $data[$channel][$key] = $value;

        $container->offsetSet(self::KEY_DATA, $data);
    }

    public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): mixed
    {
        return $this->data[$channel][$key] ?? null;
    }

    /**
     * @return array<array-key, list<string>>|list<string>
     */
    public function getMessages(
        ?string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): array {
        if ($type === null) {
            return $this->messages[$channel] ?? [];
        }

        return $this->messages[$channel][$type] ?? [];
    }

    /**
     * @param string|array<array-key, string> $message
     */
    public function addMessage(
        string $type,
        string|array $message,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): void {
        $newMessages = (array) $message;
        foreach ($newMessages as $msg) {
            if (! is_string($msg)) {
                throw new InvalidArgumentException('Flash message must be a string or an array of strings');
            }
        }

        $container = $this->getSessionContainer();

        $messages = $container->offsetGet(self::KEY_MESSAGES);
        if (! is_array($messages)) {
            $messages = [];
        }
        foreach ($newMessages as $msg) {
            $messages[$channel][$type][] = $msg;
        }

        $container->offsetSet(self::KEY_MESSAGES, $messages);
    }

    /**
     * @param string|array<array-key, string> $error
     */
    public function addError(string|array $error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
    {
        $this->addMessage(FlashMessengerInterface::ERROR, $error, $channel);
    }

    /**
     * @param string|array<array-key, string> $warning
     */
    public function addWarning(string|array $warning, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
    {
        $this->addMessage(FlashMessengerInterface::WARNING, $warning, $channel);
    }

    /**
     * @param string|array<array-key, string> $info
     */
    public function addInfo(string|array $info, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
    {
        $this->addMessage(FlashMessengerInterface::INFO, $info, $channel);
    }

    /**
     * @param string|array<array-key, string> $success
     */
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
        $this->namespace        = $namespace;
        $this->sessionContainer = null;
    }
}
