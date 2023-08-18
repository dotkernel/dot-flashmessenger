<?php

declare(strict_types=1);

namespace Dot\FlashMessenger;

use Dot\FlashMessenger\Factory\FlashMessengerFactory;
use Dot\FlashMessenger\Factory\FlashMessengerOptionsFactory;
use Dot\FlashMessenger\Factory\FlashMessengerRendererFactory;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use Dot\FlashMessenger\View\RendererInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies'       => $this->getDependencyConfig(),
            'dot_flashmessenger' => [
                'options' => [
                    'namespace' => 'dot_messenger',
                ],
            ],
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                FlashMessenger::class         => FlashMessengerFactory::class,
                FlashMessengerOptions::class  => FlashMessengerOptionsFactory::class,
                FlashMessengerRenderer::class => FlashMessengerRendererFactory::class,
            ],
            'aliases'   => [
                FlashMessengerInterface::class => FlashMessenger::class,
                RendererInterface::class       => FlashMessengerRenderer::class,
                'FlashMessenger'               => FlashMessenger::class,
            ],
        ];
    }
}
