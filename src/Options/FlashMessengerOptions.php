<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace DotKernel\DotFlashMessenger\Options;


use Zend\Stdlib\AbstractOptions;

/**
 * Class FlashMessengerOptions
 * @package DotKernel\DotFlashMessenger\Options
 */
class FlashMessengerOptions extends AbstractOptions
{
    protected $namespace = 'dot_flashmessenger';

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return FlashMessengerOptions
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    
}