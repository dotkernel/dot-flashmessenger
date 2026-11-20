<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function is_array;

class FlashMessengerOptionsFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FlashMessengerOptions
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $config = is_array($config) ? $config['dot_flashmessenger'] ?? [] : [];

        return new FlashMessengerOptions(is_array($config) ? $config : []);
    }
}
