<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Laminas\Session\ManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function class_exists;
use function is_string;

class FlashMessengerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, mixed $requestedName): FlashMessenger
    {
        $moduleOptions = $container->get(FlashMessengerOptions::class);
        $options       = $moduleOptions->getOptions() ?? [];

        if (isset($options['session_manager']) && is_string($options['session_manager'])) {
            if ($container->has($options['session_manager'])) {
                $options['session_manager'] = $container->get($options['session_manager']);
            } elseif (class_exists($options['session_manager'])) {
                $class                      = $options['session_manager'];
                $options['session_manager'] = new $class();
            }
        } elseif ($container->has(ManagerInterface::class)) {
            $options['session_manager'] = $container->get(ManagerInterface::class);
        }

        return new $requestedName($options);
    }
}
