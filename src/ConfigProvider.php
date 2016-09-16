<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger;


use Dot\FlashMessenger\Factory\FlashMessengerFactory;
use Dot\FlashMessenger\Factory\FlashMessengerMiddlewareFactory;
use Dot\FlashMessenger\Factory\FlashMessengerOptionsFactory;
use Dot\FlashMessenger\Factory\FlashMessengerRendererFactory;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Dot\FlashMessenger\View\FlashMessengerRenderer;

/**
 * Class ConfigProvider
 * @package Dot\FlashMessenger
 */
class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),

            'dot_flashmessenger' => [
                'namespace' => 'dot_flashmessenger',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'factories' => [
                FlashMessengerInterface::class => FlashMessengerFactory::class,

                FlashMessengerMiddleware::class => FlashMessengerMiddlewareFactory::class,

                FlashMessengerOptions::class => FlashMessengerOptionsFactory::class,

                FlashMessengerRenderer::class => FlashMessengerRendererFactory::class,
            ],
        ];
    }
}