<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

declare(strict_types=1);

namespace Dot\FlashMessenger;

use Dot\FlashMessenger\Exception\InvalidArgumentException;
use Dot\FlashMessenger\Exception\RuntimeException;
use Zend\Session\Container;
use Zend\Session\ManagerInterface;
use Zend\Session\SessionManager;

/**
 * Class FlashMessenger
 * @package Dot\FlashMessenger
 */
class FlashMessenger implements FlashMessengerInterface
{
    /** @var  string */
    protected $namespace = '';

    /** @var  ManagerInterface */
    protected $sessionManager;

    /** @var  Container */
    protected $sessionContainer;

    /** @var  array */
    protected $messages = [];

    /** @var array */
    protected $data = [];

    /**
     * FlashMessenger constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['namespace']) && is_string($options['namespace'])) {
            $this->setNamespace($options['namespace']);
        }

        if (isset($options['session_manager']) && $options['session_manager'] instanceof ManagerInterface) {
            $this->setSessionManager($options['session_manager']);
        }

        if (empty($this->namespace)) {
            throw new RuntimeException('Flash messenger need a namespace to be set');
        }

        $this->init();
    }

    /**
     * Initialize the messenger with the previous session messages
     */
    public function init()
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

    /**
     * @return Container
     */
    public function getSessionContainer() : Container
    {
        if (!$this->sessionContainer) {
            $this->sessionContainer = new Container($this->namespace, $this->getSessionManager());
            //start the session if not started already
            $this->sessionContainer->getManager()->start();
        }
        return $this->sessionContainer;
    }

    /**
     * @param Container $container
     */
    public function setSessionContainer(Container $container)
    {
        $this->sessionContainer = $container;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string $channel
     */
    public function addData(string $key, mixed $value, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)
    {
        $container = $this->getSessionContainer();
        if (!isset($container->data)) {
            $container->data = [];
        }

        if (! isset($container->data[$channel])) {
            $container->data[$channel] = [];
        }

        $container->data[$channel][$key] = $value;
    }

    /**
     * @param string $key
     * @param string $channel
     * @return mixed|null
     */
    public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL) : ?mixed
    {
        return isset($this->data[$channel]) ? $this->data[$channel][$key] ?? null : null;
    }

    /**
     * @param string|null $type
     * @param string $channel
     * @return array
     */
    public function getMessages(
        string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ) : array {
        if (!$type) {
            return $this->messages[$channel] ?? [];
        }

        //If the key exists then return all messages or empty array
        return isset($this->messages[$channel]) ? $this->messages[$channel][$type] ?? [] : [];
    }

    /**
     * @param mixed $error
     * @param string $channel
     */
    public function addError(mixed $error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)
    {
        $this->addMessage(FlashMessengerInterface::ERROR, $error, $channel);
    }

    /**
     * @param mixed $message
     * @param string $channel
     */
    public function addWarning(mixed $message, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)
    {
        $this->addMessage(FlashMessengerInterface::WARNING, $message, $channel);
    }

    /**
     * @param mixed $message
     * @param string $channel
     */
    public function addInfo(mixed $message, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)
    {
        $this->addMessage(FlashMessengerInterface::INFO, $message, $channel);
    }

    /**
     * @param mixed $message
     * @param string $channel
     */
    public function addSuccess(mixed $message, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)
    {
        $this->addMessage(FlashMessengerInterface::SUCCESS, $message, $channel);
    }

    /**
     * Add flash message
     *
     * @param string $type The namespace to store the message under
     * @param mixed $message Message to show on next request
     * @param string $channel
     */
    public function addMessage(string $type, mixed $message, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)
    {
        if (!is_string($message) && !is_array($message)) {
            throw new InvalidArgumentException('Flash message must be a string or an array of strings');
        }

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
            if (!is_string($msg)) {
                throw new InvalidArgumentException('Flash message must be a string or an array of strings');
            }
            $container->messages[$channel][$type][] = $msg;
        }
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return ManagerInterface
     */
    public function getSessionManager(): ManagerInterface
    {
        if (! $this->sessionManager) {
            $this->sessionManager = new SessionManager();
        }
        return $this->sessionManager;
    }

    /**
     * @param ManagerInterface $sessionManager
     */
    public function setSessionManager(ManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }
}
