<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessengerInterface;

interface RendererInterface
{
    public function render(?string $type = null, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): string;

    /**
     * @param non-empty-string $partial
     * @param array<non-empty-string, mixed> $params
     */
    public function renderPartial(
        string $partial,
        array $params = [],
        ?string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): string;
}
