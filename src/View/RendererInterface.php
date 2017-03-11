<?php
/**
 * @see https://github.com/dotkernel/dot-flashmessenger/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-flashmessenger/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessengerInterface;

/**
 * Interface RendererInterface
 * @package Dot\FlashMessenger\View
 */
interface RendererInterface
{
    /**
     * @param string|null $type
     * @param string $channel
     * @return string
     */
    public function render(
        string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): string;

    /**
     * @param string $partial
     * @param array $params
     * @param string|null $type
     * @param string $channel
     * @return string
     */
    public function renderPartial(
        string $partial,
        array $params = [],
        string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): string;
}
