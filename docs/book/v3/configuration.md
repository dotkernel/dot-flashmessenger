# Configuration

After installation, merge the `ConfigProvider` to your application's configuration.

```php
Dot\FlashMessenger\ConfigProvider::class,
```

Set the session namespace to be used for all flash messages and data.

```php
return [
    'dot_flashmessenger' => [
        'namespace' => 'flash messages session namespace name'
    ],
];
```
