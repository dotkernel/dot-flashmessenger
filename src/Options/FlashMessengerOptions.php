<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * @extends AbstractOptions<mixed>
 */
class FlashMessengerOptions extends AbstractOptions
{
    /** @var array<string, mixed> */
    protected array $options = [];

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
