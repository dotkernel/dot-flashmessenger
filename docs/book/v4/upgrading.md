# Upgrading

## Upgrading from 3.x to 4.0

Version 4.0 has changes that can break code that worked with version 3.x. Read the table, then make the related change in your application.

| Change | Symptom | Fix |
| --- | --- | --- |
| PHP 8.2 is no longer supported | Composer does not install 4.0 on PHP 8.2 | Use PHP 8.3 or newer |
| An invalid `session_manager` option throws | `RuntimeException`: "The session manager ... is not a container service and not a class that implements Laminas\Session\ManagerInterface." | Use a container service name, or a class that implements `Laminas\Session\ManagerInterface`. See [Configuration](configuration.md) |
| `FlashMessengerFactory` always creates `FlashMessenger` | A subclass that you mapped to this factory is not created | Write a factory for your subclass |
| `render()` returns HTML | `{{ messages() }}` in Twig now prints lists of messages | Remove the call, or use `messagesPartial()` for your own markup. See [Renderer](renderer.md) |
| The namespace error message changed, and an empty namespace is an error | `RuntimeException`: "The flash messenger needs a namespace." | Set a non-empty `dot_flashmessenger.options.namespace` |
| `getMessages('')` returns an empty array | Code that sends `''` for "all types" gets no messages | Send `null` |
| `psr/http-message` is no longer required | A class is not found, if your application used `psr/http-message` but did not require it | Require `psr/http-message` in your application |

The session keys did not change. Messages and data that version 3.x saved are available after the upgrade.

## dot-twigrenderer

`dotkernel/dot-twigrenderer` uses this package for its `messages()` and `messagesPartial()` Twig functions. Upgrade to a version of `dot-twigrenderer` that allows `dotkernel/dot-flashmessenger` version 4.
