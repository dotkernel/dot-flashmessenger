<?php
/**
 * @see https://github.com/dotkernel/dot-flashmessenger/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-flashmessenger/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Class FlashMessengerOptions
 * @package Dot\FlashMessenger\Options
 */
class FlashMessengerOptions extends AbstractOptions
{
    /** @var array */
    protected $options = [];

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}
