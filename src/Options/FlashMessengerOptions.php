<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * @template TValue
 * @template-extends AbstractOptions<TValue>
 */
class FlashMessengerOptions extends AbstractOptions
{
    protected array $options = [];

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
