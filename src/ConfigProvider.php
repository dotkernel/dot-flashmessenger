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
    /**
     * @return array{
     *     dependencies: array{factories: array<class-string, class-string>, aliases: array<string, class-string>},
     *     dot_flashmessenger: array{options: array{namespace: non-empty-string}},
     * }
     */
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

    /**
     * @return array{factories: array<class-string, class-string>, aliases: array<string, class-string>}
     */
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
