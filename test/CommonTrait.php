<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger;

use Laminas\Session\Config\StandardConfig;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\ArrayStorage;

trait CommonTrait
{
    /** @var array{dot_flashmessenger: array{options: array{namespace: string, session_manager: class-string}}} */
    protected array $config = [
        'dot_flashmessenger' => [
            'options' => [
                'namespace'       => 'dot_messenger',
                'session_manager' => SessionManager::class,
            ],
        ],
    ];

    /**
     * A session manager that keeps the data in memory, so tests do not share $_SESSION.
     */
    protected function createSessionManager(): SessionManager
    {
        return new SessionManager(new StandardConfig(), new ArrayStorage());
    }
}
