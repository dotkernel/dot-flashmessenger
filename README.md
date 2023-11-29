# dot-flashmessenger


![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-flashmessenger)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-flashmessenger/3.4.1)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-flashmessenger)](https://github.com/dotkernel/dot-flashmessenger/blob/3.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/static-analysis.yml/badge.svg?branch=3.0)](https://github.com/dotkernel/dot-flashmessenger/actions/workflows/static-analysis.yml)
[![codecov](https://codecov.io/gh/dotkernel/dot-flashmessenger/graph/badge.svg?token=B4WAT3RYKJ)](https://codecov.io/gh/dotkernel/dot-flashmessenger)

[![SymfonyInsight](https://insight.symfony.com/projects/94ace687-5124-446f-a324-0ecca1b47f88/big.svg)](https://insight.symfony.com/projects/94ace687-5124-446f-a324-0ecca1b47f88)


Flash messenger library for session messages between redirects. A flash message, or session message is a piece of text data that survives one requests(available only in the next request). 
This library accepts session data as well, not just string messages, with the same behaviour.
The flash messenger is a convenient way to add data to the session and get it back on the next request without bothering with setting and clearing the data manually.

## Installation

Run the following command in your project folder
```bash
$ composer require dotkernel/dot-flashmessenger
```

This will also install `laminas/laminas-session` as session handling is based on this library.
Next, merge the `ConfigProvider` to your application's configuration

## Configuration

```php
return [
    'dot_flashmessenger' => [
        'namespace' => 'flash messeges session namespace name'
    ],
];
```

Sets the session namespace to use for all flash messages and data

## Usage

If following the installation step, you'll already have a FlashMessenger service in the service manager.
Just inject this service in you classes, wherever you need flash messages.

##### Getting the service in a factory
```php
$container->get(FlashMessengerInterface::class);
```

##### Using the flash messenger service
To add and retrieve text messages
```php
$this->flashMessenger->addMessage('error', 'This is a error flash message');

//on the next request you can get all messages from a namespace, or all messages from all namespaces if namespace is omitted
$this->flashMessenger->getMessages('error');
```

Adding general data, not just messages, has a different method for that, accepting data as key/value pairs
```php
$this->flashMessenger->addData('myData', $someData);

//next request
$this->flashMessenger->getData('myData');
```

There are also some predefined namespaces, along with shortcuts to add a message in the predefined namespaces
```php
FlashMessengerInterface::ERROR_NAMESPACE
FlashMessengerInterface::WARNING_NAMESPACE 
FlashMessengerInterface::INFO_NAMESPACE 
FlashMessengerInterface::SUCCESS_NAMESPACE 
```

```php
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
```

## FlashMessengerRenderer

A class that is able to parse the content of the flash messenger service in an HTML format. 
It uses the TemplateInterface to parse a partial, sending to the partial template the messages, the service and the renderer itself.
There are also a twig extension provided in [dot-twigrenderer](https://github.com/dotkernel/dot-twigrenderer), for easy parsing of messages blocks.

## Registered services

```php
Dot\FlashMessenger\FlashMessengerInterface::class
```

The flash messenger service

```php
Dot\FlashMessenger\View\RendererInterface::class
```

The registered renderer class
