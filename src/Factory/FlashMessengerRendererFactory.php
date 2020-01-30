<?php
/**
 * @see https://github.com/dotkernel/dot-flashmessenger/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-flashmessenger/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use Psr\Container\ContainerInterface;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class FlashMessengerRendererFactory
 * @package Dot\FlashMessenger\Factory
 */
class FlashMessengerRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return FlashMessengerRenderer
     */
    public function __invoke(ContainerInterface $container)
    {
        return new FlashMessengerRenderer(
            $container->get(TemplateRendererInterface::class),
            $container->get(FlashMessengerInterface::class)
        );
    }
}
