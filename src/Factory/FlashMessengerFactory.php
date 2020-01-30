<?php
/**
 * @see https://github.com/dotkernel/dot-flashmessenger/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-flashmessenger/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Psr\Container\ContainerInterface;
use Laminas\Session\ManagerInterface;

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
        } elseif ($container->has(ManagerInterface::class)) {
            $options['session_manager'] = $container->get(ManagerInterface::class);
        }

        return new $requestedName($options);
    }
}
