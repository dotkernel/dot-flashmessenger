# Configuration

After installation, add the `ConfigProvider` to the configuration of your application:

```php
Dot\FlashMessenger\ConfigProvider::class,
```

The `ConfigProvider` sets the session namespace `dot_messenger`. To change the options, add this configuration:

```php
return [
    'dot_flashmessenger' => [
        'options' => [
            'namespace'       => 'flash_messages',
            'session_manager' => Laminas\Session\SessionManager::class,
        ],
    ],
];
```

## Options

| Option | Required | Description |
| --- | --- | --- |
| `namespace` | Yes | The session namespace for all flash messages and data. It must be a non-empty string |
| `session_manager` | No | The session manager. See below |

The factory finds the session manager in this order:

1. If `session_manager` is the name of a container service, the factory gets that service.
2. If `session_manager` is the name of a class that implements `Laminas\Session\ManagerInterface`, the factory creates it.
3. If `session_manager` is not set, the factory gets the `Laminas\Session\ManagerInterface` service, if the container has it.
4. If none of the above applies, `FlashMessenger` creates a `Laminas\Session\SessionManager`.

If `session_manager` is set but the factory cannot use it, the factory throws `Dot\FlashMessenger\Exception\RuntimeException`. This occurs when the name is not a service and not a class, or when the service or the class does not implement `Laminas\Session\ManagerInterface`.

If `namespace` is missing or empty, `FlashMessenger` throws `Dot\FlashMessenger\Exception\RuntimeException` with the message "The flash messenger needs a namespace."
