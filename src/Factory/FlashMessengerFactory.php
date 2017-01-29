<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

declare(strict_types=1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Interop\Container\ContainerInterface;
use Zend\Session\ManagerInterface;

/**
 * Class FlashMessengerFactory
 * @package Dot\FlashMessenger\Factory
 */
class FlashMessengerFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @return FlashMessenger
     */
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        /** @var FlashMessengerOptions $options */
        $moduleOptions = $container->get(FlashMessengerOptions::class);
        $options = $moduleOptions->getOptions() ?? [];

        if (isset($options['session_manager']) && is_string($options['session_manager'])) {
            if ($container->has($options['session_manager'])) {
                $options['session_manager'] = $container->get($options['session_manager']);
            } elseif (class_exists($options['session_manager'])) {
                $class = $options['session_manager'];
                $options['session_manager'] = new $class();
            }
        }

        //lets try to get the default session manager from the container, if it is available
        if (!$options['session_manager'] instanceof ManagerInterface) {
            if ($container->has(ManagerInterface::class)) {
                $options['session_manager'] = $container->get(ManagerInterface::class);
            }
        }

        return new $requestedName($options);
    }
}
