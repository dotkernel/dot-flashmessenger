<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace DotKernel\DotFlashMessenger\Factory;

use DotKernel\DotFlashMessenger\FlashMessenger;
use DotKernel\DotFlashMessenger\Options\FlashMessengerOptions;
use Interop\Container\ContainerInterface;

/**
 * Class FlashMessengerFactory
 * @package DotKernel\DotFlashMessenger\Factory
 */
class FlashMessengerFactory
{
    /**
     * @param ContainerInterface $container
     * @return FlashMessenger
     */
    public function __invoke(ContainerInterface $container)
    {
        $options = $container->get(FlashMessengerOptions::class);
        return new FlashMessenger($options->getFlashMessengerOptions()->getNamespace());
    }
}