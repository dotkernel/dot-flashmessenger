# dot-flashmessenger

Flash messenger library for session messages between redirects.
A flash message, or session message is a piece of text data that survives one request (available only in the next request).
This library accepts session data as well, not just string messages, with the same behavior.
The flash messenger is a convenient way to add data to the session and get it back on the next request without bothering with setting and clearing the data manually.

## Documentation

Documentation is available at: https://docs.dotkernel.org/dot-flashmessenger/.

## Badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-flashmessenger)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-flashmessenger/3.7.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/blob/3.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/continuous-integration.yml/badge.svg?branch=3.0)](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/dot-flashmessenger/graph/badge.svg?token=B4WAT3RYKJ)](https://codecov.io/gh/dotkernel/dot-flashmessenger)
[![PHPStan](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/static-analysis.yml/badge.svg?branch=3.0)](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/static-analysis.yml)

## Installation

Run the following command in your project folder

```shell
composer require dotkernel/dot-flashmessenger
```

This will also install `laminas/laminas-session` as session handling is based on this library.
Next, merge the `ConfigProvider` to your application's configuration.

## Configuration

```php
return [
    'dot_flashmessenger' => [
        'namespace' => 'flash messages session namespace name'
    ],
];
```

Sets the session namespace to be used for all flash messages and data.

## Usage

If following the installation step, you'll already have a FlashMessenger service in the service manager.
Inject this service in your classes, wherever you need flash messages.

### Getting the service in a factory

```php
$container->get(FlashMessengerInterface::class);
```

### Using the flash messenger service

To add and retrieve text messages

```php
$this->flashMessenger->addMessage('error', 'This is a error flash message');
//on the next request you can get all messages from a namespace, or all messages from all namespaces if the namespace is omitted
$this->flashMessenger->getMessages('error');
```

Adding general data, not just messages, has a different method for that, accepting data as key/value pairs

```php
$this->flashMessenger->addData('myData', $someData);
// next request
$this->flashMessenger->getData('myData');
```

There are also some predefined namespaces, along with shortcuts to add a message in the predefined namespaces

```php
FlashMessengerInterface::ERROR_NAMESPACE
FlashMessengerInterface::WARNING_NAMESPACE 
FlashMessengerInterface::INFO_NAMESPACE 
FlashMessengerInterface::SUCCESS_NAMESPACE
```

using the methods:

```php
public function addError(string|array $error);

public function addInfo(string|array $info);

public function addWarning(string|array $warning);

public function addSuccess(string|array $success);
```

## FlashMessengerRenderer

A class that is able to parse the content of the flash messenger service in an HTML format.
It uses the TemplateInterface to parse a partial, sending to the partial template the messages, the service and the renderer itself.
There is also a Twig extension provided in [dot-twigrenderer](https://github.com/dotkernel/dot-twigrenderer), for easy parsing of messages blocks.

## Registered services

```php
Dot\FlashMessenger\FlashMessengerInterface::class
```

The flash messenger service

```php
Dot\FlashMessenger\View\RendererInterface::class
```
