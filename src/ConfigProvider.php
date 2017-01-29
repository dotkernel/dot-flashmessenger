<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger;

use Dot\FlashMessenger\Factory\FlashMessengerFactory;
use Dot\FlashMessenger\Factory\FlashMessengerOptionsFactory;
use Dot\FlashMessenger\Factory\FlashMessengerRendererFactory;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Dot\FlashMessenger\View\RendererInterface;

/**
 * Class ConfigProvider
 * @package Dot\FlashMessenger
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),

            'dot_flashmessenger' => [
                'options' => [
                    'namespace' => 'dot_messenger',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                FlashMessenger::class => FlashMessengerFactory::class,
                FlashMessengerOptions::class => FlashMessengerOptionsFactory::class,
                RendererInterface::class => FlashMessengerRendererFactory::class,
            ],
            'aliases' => [
                'FlashMessenger' => FlashMessenger::class,
                FlashMessengerInterface::class => FlashMessenger::class,
            ]
        ];
    }
}
