<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

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