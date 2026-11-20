<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\Exception\RuntimeException;
use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Laminas\Session\ManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function class_exists;
use function get_debug_type;
use function is_a;
use function is_string;
use function sprintf;

class FlashMessengerFactory
{
    /**
     * The factory always creates a FlashMessenger. It does not use $requestedName, because a container
     * can send an alias such as FlashMessengerInterface::class or 'FlashMessenger'.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RuntimeException
     */
    public function __invoke(ContainerInterface $container, mixed $requestedName = null): FlashMessenger
    {
        $moduleOptions = $container->get(FlashMessengerOptions::class);
        if (! $moduleOptions instanceof FlashMessengerOptions) {
            throw new RuntimeException(sprintf('The service "%s" is not valid.', FlashMessengerOptions::class));
        }
        $options = $moduleOptions->getOptions();

        if (isset($options['session_manager']) && is_string($options['session_manager'])) {
            $options['session_manager'] = $this->resolveSessionManager($container, $options['session_manager']);
        } elseif ($container->has(ManagerInterface::class)) {
            $options['session_manager'] = $container->get(ManagerInterface::class);
        }

        return new FlashMessenger($options);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RuntimeException
     */
    private function resolveSessionManager(ContainerInterface $container, string $name): ManagerInterface
    {
        if ($container->has($name)) {
            $sessionManager = $container->get($name);
        } elseif (class_exists($name) && is_a($name, ManagerInterface::class, true)) {
            $sessionManager = new $name();
        } else {
            throw new RuntimeException(sprintf(
                'The session manager "%s" is not a container service and not a class that implements %s.',
                $name,
                ManagerInterface::class
            ));
        }

        if (! $sessionManager instanceof ManagerInterface) {
            throw new RuntimeException(sprintf(
                'The session manager "%s" must implement %s. The container returned %s.',
                $name,
                ManagerInterface::class,
                get_debug_type($sessionManager)
            ));
        }

        return $sessionManager;
    }
}
