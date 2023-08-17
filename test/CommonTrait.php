<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger;

use Laminas\Session\SessionManager;

trait CommonTrait
{
    protected array $config = [
        'dot_flashmessenger' => [
            'options' => [
                'namespace'       => 'dot_messenger',
                'session_manager' => SessionManager::class,
            ],
        ],
    ];
}
