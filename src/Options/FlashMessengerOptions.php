<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger\Options;

use Zend\Stdlib\AbstractOptions;

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
