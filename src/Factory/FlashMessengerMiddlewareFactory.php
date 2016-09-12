<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace DotKernel\DotFlashMessenger\Factory;

use DotKernel\DotFlashMessenger\FlashMessengerInterface;
use DotKernel\DotFlashMessenger\FlashMessengerMiddleware;
use Interop\Container\ContainerInterface;

/**
 * Class FlashMessengerMiddlewareFactory
 * @package DotKernel\DotFlashMessenger\Factory
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