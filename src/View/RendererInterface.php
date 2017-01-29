<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 12/20/2016
 * Time: 1:08 AM
 */

declare(strict_types=1);

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
    ) : string;

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
    ) : string;
}
