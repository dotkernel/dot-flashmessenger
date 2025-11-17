# Usage

If following the installation step, you'll already have a FlashMessenger service in the service manager.
Inject this service in your classes, wherever you need flash messages.

## Using the flash messenger service

To add and retrieve text messages

```php
$this->flashMessenger->addMessage('error', 'This is a error flash message');

//on the next request you can get all messages from a namespace, or all messages from all namespaces if the namespace is omitted
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
public function addError(string|array $error, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
{
    $this->addMessage(FlashMessengerInterface::ERROR, $error, $channel);
}

public function addWarning(string|array $warning, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
{
    $this->addMessage(FlashMessengerInterface::WARNING, $warning, $channel);
}

public function addInfo(string|array $info, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
{
    $this->addMessage(FlashMessengerInterface::INFO, $info, $channel);
}

public function addSuccess(string|array $success, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): void
{
    $this->addMessage(FlashMessengerInterface::SUCCESS, $success, $channel);
}
```
