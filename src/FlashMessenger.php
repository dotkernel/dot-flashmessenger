<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger;

use Dot\FlashMessenger\Exception\InvalidArgumentException;
use Zend\Session\Container;

/**
 * Class FlashMessenger
 * @package Dot\FlashMessenger
 */
class FlashMessenger implements FlashMessengerInterface
{
    /** @var  string */
    protected $namespace;

    /** @var  Container */
    protected $sessionContainer;

    /** @var  array */
    protected $messages = [];

    /** @var array */
    protected $data = [];

    /**
     * FlashMessenger constructor.
     * @param string $namespace
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
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
    public function getSessionContainer()
    {
        if (!$this->sessionContainer) {
            $this->sessionContainer = new Container($this->namespace);
            //start the session if not started already
            $this->sessionContainer->getManager()->start();
        }
        return $this->sessionContainer;
    }

    /**
     * @param Container $container
     * @return $this
     */
    public function setSessionContainer(Container $container)
    {
        $this->sessionContainer = $container;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addData($key, $value)
    {
        $container = $this->getSessionContainer();
        if (!isset($container->data)) {
            $container->data = [];
        }

        $container->data[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getData($key)
    {
        return isset($this->data[$key])
            ? $this->data[$key]
            : null;
    }

    /**
     * Add flash message
     *
     * @param string $namespace The namespace to store the message under
     * @param string[]|string $message Message to show on next request
     */
    public function addMessage($namespace, $message)
    {
        if(!is_string($message) && !is_array($message)) {
            throw new InvalidArgumentException('Flash message must be a string or an array of strings');
        }

        $container = $this->getSessionContainer();
        if (!isset($container->messages)) {
            $container->messages = [];
        }

        if (!isset($container->messages[$namespace])) {
            $container->messages[$namespace] = [];
        }

        //make it uniform to an array
        if(!is_array($message)) {
            $message = [$message];
        }

        foreach ($message as $msg) {
            if(!is_string($msg)) {
                throw new InvalidArgumentException('Flash message must be a string or an array of strings');
            }
            $container->messages[$namespace][] = $msg;
        }
    }

    /**
     * Get Flash Message
     *
     * @param string $namespace The namespace to get the message from
     * @return mixed|null Returns the message
     */
    public function getMessages($namespace = null)
    {
        if (!$namespace) {
            return $this->messages;
        }

        //If the key exists then return all messages or empty array
        return (isset($this->messages[$namespace])
            ? $this->messages[$namespace]
            : []);
    }

    /**
     * @param $error
     */
    public function addError($error)
    {
        $this->addMessage(FlashMessengerInterface::ERROR_NAMESPACE, $error);
    }

    /**
     * @param $message
     */
    public function addWarning($message)
    {
        $this->addMessage(FlashMessengerInterface::WARNING_NAMESPACE, $message);
    }

    /**
     * @param $message
     */
    public function addInfo($message)
    {
        $this->addMessage(FlashMessengerInterface::INFO_NAMESPACE, $message);
    }

    /**
     * @param $message
     */
    public function addSuccess($message)
    {
        $this->addMessage(FlashMessengerInterface::SUCCESS_NAMESPACE, $message);
    }
}