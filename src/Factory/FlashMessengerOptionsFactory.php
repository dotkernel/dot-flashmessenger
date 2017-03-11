<?php
/**
 * @see https://github.com/dotkernel/dot-flashmessenger/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-flashmessenger/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger\Factory;

use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Interop\Container\ContainerInterface;

/**
 * Class FlashMessengerOptionsFactory
 * @package Dot\FlashMessenger\Factory
 */
class FlashMessengerOptionsFactory
{
    /**
     * @param ContainerInterface $container
     * @return FlashMessengerOptions
     */
    public function __invoke(ContainerInterface $container)
    {
        return new FlashMessengerOptions($container->get('config')['dot_flashmessenger']);
    }
}
