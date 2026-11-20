# Installation

Version 4 requires PHP 8.3 or newer.

Run this command in your project folder:

```shell
composer require dotkernel/dot-flashmessenger
```

Composer also installs `laminas/laminas-session`, because the session handling uses this library.

If you use `dotkernel/dot-twigrenderer`, make sure that your version of it allows `dotkernel/dot-flashmessenger` version 4. If it does not, Composer cannot install version 4.

To upgrade from version 3, read [Upgrading](upgrading.md).
