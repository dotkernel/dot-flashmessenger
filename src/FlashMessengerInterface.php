<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

declare(strict_types = 1);

namespace Dot\FlashMessenger;

/**
 * Interface FlashMessengerInterface
 * @package Dot\FlashMessenger
 */
interface FlashMessengerInterface
{
    const ERROR = 'error';
    const WARNING = 'warning';
    const INFO = 'info';
    const SUCCESS = 'success';

    const DEFAULT_CHANNEL = 'flash_messenger.channel.default';

    /**
     * @param string $key
     * @param mixed $value
     * @param string $channel
     */
    public function addData(string $key, $value, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param string $key
     * @param string $channel
     * @return mixed|null
     */
    public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param string $type
     * @param mixed $message
     * @param string $channel
     */
    public function addMessage(
        string $type,
        $message,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    );

    /**
     * @param string|null $type
     * @param string $channel
     * @return array
     */
    public function getMessages(
        string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): array;

    /**
     * @param mixed $error
     * @param string $channel
     */
    public function addError($error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param mixed $info
     * @param string $channel
     */
    public function addInfo($info, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param mixed $warning
     * @param string $channel
     */
    public function addWarning($warning, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param mixed $success
     * @param string $channel
     */
    public function addSuccess($success, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);
}
