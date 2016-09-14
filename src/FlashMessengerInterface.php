<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger;


/**
 * Interface FlashMessengerInterface
 * @package Dot\FlashMessenger
 */
interface FlashMessengerInterface
{
    const ERROR_NAMESPACE = 'error';
    const WARNING_NAMESPACE = 'warning';
    const INFO_NAMESPACE = 'info';
    const SUCCESS_NAMESPACE = 'success';

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addData($key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function getData($key);

    /**
     * @param string $namespace
     * @param string $message
     * @return void
     */
    public function addMessage($namespace, $message);

    /**
     * @param null $namespace
     * @return array
     */
    public function getMessages($namespace = null);

    /**
     * @param string $error
     * @return void
     */
    public function addError($error);

    /**
     * @param string $info
     * @return void
     */
    public function addInfo($info);

    /**
     * @param string $warning
     * @return void
     */
    public function addWarning($warning);

    /**
     * @param string $success
     * @return void
     */
    public function addSuccess($success);
}