<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\FlashMessengerMiddleware;
use Interop\Container\ContainerInterface;

/**
 * Class FlashMessengerMiddlewareFactory
 * @package Dot\FlashMessenger\Factory
 */
class FlashMessengerMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return FlashMessengerMiddleware
     */
    public function __invoke(ContainerInterface $container)
    {
        $flashMessenger = $container->get(FlashMessengerInterface::class);
        return new FlashMessengerMiddleware($flashMessenger);
    }
}