# dot-flashmessenger

Flash messenger library for session messages between redirects.
A flash message, or session message, is a piece of text that is available only in the next request.
The library also keeps other session data, not only text messages, with the same behavior.
With the flash messenger, you add data to the session and get it back in the next request. You do not set and clear the data yourself.

## Documentation

Documentation is available at: https://docs.dotkernel.org/dot-flashmessenger/.

## Badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-flashmessenger)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-flashmessenger/4.0.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/blob/4.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/continuous-integration.yml/badge.svg?branch=4.0)](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/dot-flashmessenger/graph/badge.svg?token=B4WAT3RYKJ)](https://codecov.io/gh/dotkernel/dot-flashmessenger)
[![PHPStan](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/static-analysis.yml/badge.svg?branch=4.0)](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/static-analysis.yml)

## Versions

| Version | PHP | Documentation |
| --- | --- | --- |
| 4.x | 8.3, 8.4, 8.5, 8.6 | `docs/book/v4` |
| 3.x | 8.2, 8.3, 8.4, 8.5 | `docs/book/v3` |

To upgrade from 3.x, read `docs/book/v4/upgrading.md`.

## Installation

Run this command in your project folder:

```shell
composer require dotkernel/dot-flashmessenger
```

Composer also installs `laminas/laminas-session`, because the session handling uses this library.
Next, add the `ConfigProvider` to the configuration of your application.

## Configuration

```php
return [
    'dot_flashmessenger' => [
        'options' => [
            'namespace'       => 'flash_messages',
            // Optional: a container service name, or a class that implements Laminas\Session\ManagerInterface.
            'session_manager' => Laminas\Session\SessionManager::class,
        ],
    ],
];
```

`namespace` is the session namespace for all flash messages and data. The `ConfigProvider` sets it to `dot_messenger`.

## Usage

After the installation, the container has a `FlashMessengerInterface` service.
Inject this service into the classes that need flash messages.

### Getting the service in a factory

```php
$container->get(FlashMessengerInterface::class);
```

### Using the flash messenger service

A message that you add in a request is available only in the next request.

```php
$this->flashMessenger->addMessage(FlashMessengerInterface::ERROR, 'This is an error flash message');
// In the next request, get the messages of one type, or of all types if you omit the type:
$this->flashMessenger->getMessages(FlashMessengerInterface::ERROR);
$this->flashMessenger->getMessages();
```

For data that is not a message, use `addData()` and `getData()` with a key:

```php
$this->flashMessenger->addData('myData', $someData);
// In the next request:
$this->flashMessenger->getData('myData');
```

The interface has constants for the usual message types:

```php
FlashMessengerInterface::ERROR
FlashMessengerInterface::WARNING
FlashMessengerInterface::INFO
FlashMessengerInterface::SUCCESS
```

Each type has a shortcut method:

```php
public function addError(string|array $error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;

public function addInfo(string|array $info, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;

public function addWarning(string|array $warning, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;

public function addSuccess(string|array $success, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void;
```

## FlashMessengerRenderer

This class turns the messages into HTML.
`render()` returns escaped HTML lists. `renderPartial()` renders your template with the messages, the service and the renderer.
[dot-twigrenderer](https://github.com/dotkernel/dot-twigrenderer) gives Twig functions that use this renderer.

## Registered services

```php
Dot\FlashMessenger\FlashMessengerInterface::class
```

The flash messenger service

```php
Dot\FlashMessenger\View\RendererInterface::class
```

The renderer service
