<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FlashMessengerRendererFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FlashMessengerRenderer
    {
        return new FlashMessengerRenderer(
            $container->get(TemplateRendererInterface::class),
            $container->get(FlashMessengerInterface::class)
        );
    }
}
