# Usage

After the installation, the container has a `FlashMessengerInterface` service. Inject this service into the classes that need flash messages.

## Getting the service in a factory

```php
$flashMessenger = $container->get(Dot\FlashMessenger\FlashMessengerInterface::class);
```

## Adding and reading messages

A message that you add in a request is available only in the next request. In the request that adds the message, `getMessages()` does not return it.

```php
use Dot\FlashMessenger\FlashMessengerInterface;

// In this request:
$flashMessenger->addMessage(FlashMessengerInterface::ERROR, 'The form has errors.');

// In the next request:
$flashMessenger->getMessages(FlashMessengerInterface::ERROR); // ['The form has errors.']
$flashMessenger->getMessages();                               // ['error' => ['The form has errors.']]
```

`getMessages()` without a type returns all messages of the channel, grouped by type. With a type, it returns the list of messages of that type. If there are no messages, it returns an empty array.

## Message types

The interface has constants for the usual message types:

```php
FlashMessengerInterface::ERROR   // 'error'
FlashMessengerInterface::WARNING // 'warning'
FlashMessengerInterface::INFO    // 'info'
FlashMessengerInterface::SUCCESS // 'success'
```

Each type has a shortcut method. Each method accepts one message or an array of messages:

```php
$flashMessenger->addError('The form has errors.');
$flashMessenger->addWarning(['Your password expires soon.', 'Your email is not confirmed.']);
$flashMessenger->addInfo('Check your email.');
$flashMessenger->addSuccess('Your account was saved.');
```

A message must be a string. If one item of an array is not a string, the method throws `Dot\FlashMessenger\Exception\InvalidArgumentException` and adds no message.

## Channels

All methods have an optional last argument, `$channel`. The default channel is `FlashMessengerInterface::DEFAULT_CHANNEL`. Use channels to keep groups of messages apart, for example for one part of a page.

```php
// In this request:
$flashMessenger->addInfo('Check your email.', 'account');

// In the next request:
$flashMessenger->getMessages(null, 'account');                          // ['info' => ['Check your email.']]
$flashMessenger->getMessages(FlashMessengerInterface::INFO, 'account'); // ['Check your email.']
$flashMessenger->getMessages();                                         // []
```

## Adding and reading data

Use `addData()` and `getData()` for values that are not messages. The value can be of any type that the session can store.

```php
// In this request:
$flashMessenger->addData('formData', ['email' => 'user@example.com']);

// In the next request:
$flashMessenger->getData('formData'); // ['email' => 'user@example.com']
$flashMessenger->getData('missing');  // null
```

## Changing the namespace or the session manager

`FlashMessenger` reads the messages and the data of the previous request when you create it. `setNamespace()` and `setSessionManager()` make the messenger use a new session container for the messages that you add after the call. They do not read the messages of the new namespace again.
