<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\Exception\RuntimeException;
use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Interop\Container\ContainerInterface;
use Zend\Session\AbstractContainer;
use Zend\Session\Container;
use Zend\Session\ManagerInterface;

/**
 * Class FlashMessengerFactory
 * @package Dot\FlashMessenger\Factory
 */
class FlashMessengerFactory
{
    /**
     * @param ContainerInterface $container
     * @return FlashMessenger
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var FlashMessengerOptions $options */
        $options = $container->get(FlashMessengerOptions::class);
        $flashMessenger = new FlashMessenger($options->getNamespace());

        $sessionManager = null;
        $sessionContainer = null;
        if ($container->has(ManagerInterface::class)) {
            $sessionManager = $container->get(ManagerInterface::class);
            if (!$sessionManager instanceof ManagerInterface) {
                throw new RuntimeException('Session manager must be an instance of ' . ManagerInterface::class);
            }
            $sessionContainer = new Container($options->getNamespace(), $sessionManager);
        }

        if ($sessionContainer && $sessionContainer instanceof AbstractContainer) {
            $flashMessenger->setSessionContainer($sessionContainer);
        }

        $flashMessenger->init();
        return $flashMessenger;
    }
}
