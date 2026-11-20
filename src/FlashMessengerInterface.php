<?php

declare(strict_types=1);

namespace Dot\FlashMessenger;

interface FlashMessengerInterface
{
    public const ERROR   = 'error';
    public const WARNING = 'warning';
    public const INFO    = 'info';
    public const SUCCESS = 'success';

    public const DEFAULT_CHANNEL = 'flash_messenger.channel.default';

    public function addData(
        string $key,
        mixed $value,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): void;

    public function getData(string $key, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): mixed;

    /**
     * @param string|array<array-key, string> $message
     */
    public function addMessage(
        string $type,
        string|array $message,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): void;

    /**
     * Without a type, returns the messages of the channel grouped by type.
     * With a type, returns the list of messages of that type.
     *
     * @return array<array-key, list<string>>|list<string>
     */
    public function getMessages(
        ?string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): array;

    /**
     * @param string|array<array-key, string> $error
     */
    public function addError(string|array $error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;

    /**
     * @param string|array<array-key, string> $info
     */
    public function addInfo(string|array $info, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;

    /**
     * @param string|array<array-key, string> $warning
     */
    public function addWarning(string|array $warning, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;

    /**
     * @param string|array<array-key, string> $success
     */
    public function addSuccess(string|array $success, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;
}
