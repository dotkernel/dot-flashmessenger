<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

declare(strict_types=1);

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
    public function addData(string $key, mixed $value, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param string $key
     * @param string $channel
     * @return mixed|null
     */
    public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL) : ?mixed;

    /**
     * @param string $type
     * @param mixed $message
     * @param string $channel
     */
    public function addMessage(
        string $type,
        mixed $message,
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
    ) : array;

    /**
     * @param mixed $error
     * @param string $channel
     */
    public function addError(mixed $error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param mixed $info
     * @param string $channel
     */
    public function addInfo(mixed $info, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param mixed $warning
     * @param string $channel
     */
    public function addWarning(mixed $warning, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);

    /**
     * @param mixed $success
     * @param string $channel
     */
    public function addSuccess(mixed $success, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL);
}
