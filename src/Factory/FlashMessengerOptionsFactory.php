<?php
/**
 * Created by PhpStorm.
 * User: n3vrax
 * Date: 9/9/2016
 * Time: 8:48 PM
 */

namespace DotKernel\DotFlashMessenger\Factory;

use DotKernel\DotFlashMessenger\Options\FlashMessengerOptions;
use Interop\Container\ContainerInterface;

/**
 * Class FlashMessengerOptionsFactory
 * @package DotKernel\DotFlashMessenger\Factory
 */
class FlashMessengerOptionsFactory
{
    /**
     * @param ContainerInterface $container
     * @return FlashMessengerOptions
     */
    public function __invoke(ContainerInterface $container)
    {
        return new FlashMessengerOptions($container->get('config')['dot_flashmessenger']);
    }
}