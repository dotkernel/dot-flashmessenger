# Changelog

## 4.0.0 - TBD

### Changed

- Require PHP 8.3, 8.4, 8.5 or 8.6.
- Require `laminas/laminas-session` `^2.21.0` and `mezzio/mezzio-template` `^2.10.0 || ^3.0.0`.
- `FlashMessengerFactory` throws `RuntimeException` when it cannot resolve the `session_manager` option.
- `FlashMessengerFactory` always creates `FlashMessenger`.
- `FlashMessenger` rejects an empty namespace. The error message is now "The flash messenger needs a namespace."
- `FlashMessenger::setNamespace()` and `setSessionManager()` make the messenger use a new session container.
- `FlashMessenger::getMessages()` returns all types only when the type is `null`.
- Update PHPUnit to 12.5 and PHPStan to level 8.

### Added

- `FlashMessengerRenderer::render()` renders the messages as escaped HTML lists.
- Declare `laminas/laminas-stdlib` and `psr/container`, which the code uses.
- Documentation for version 4 and an upgrade guide.

### Deprecated

- Nothing

### Removed

- Support for PHP 8.2.
- The `psr/http-message` requirement, which the code does not use.

### Fixed

- `addMessage()` wrote some messages of an array before it threw for an invalid message.
- `FlashMessengerOptionsFactory` raised a PHP warning when the `dot_flashmessenger` key was missing.
- The documentation showed a configuration that does not work and constants that do not exist.

## 3.7.0 - 2025-11-17

### Changed

- Require PHP 8.2, 8.3, 8.4 or 8.5.
- Allow `mezzio/mezzio-template` `^3.0.0`.

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Support for PHP 8.1.

### Fixed

- Nothing

## 3.6.1 - 2025-03-12

### Changed

- Nothing

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Rename the workflow file `continous-integration.yml` to `continuous-integration.yml`.

## 3.6.0 - 2025-03-12

### Changed

- Replace Psalm with PHPStan.

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 3.5.0 - 2024-05-03

### Changed

- Replace the test, static analysis and coding standard workflows with the Laminas continuous integration workflow.

### Added

- Documentation in `docs/book/v3`.

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 3.4.2 - 2023-11-29

### Changed

- Nothing

### Added

- Support for PHP 8.3.

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 3.4.1 - 2023-08-19

### Changed

- Nothing

### Added

- Codecov badge.

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Restore the `FlashMessengerRenderer::render()` signature of 3.3.0 (issue #17).

## 3.4.0 - 2023-08-18

### Changed

- Require PHP 8.1 or 8.2, `laminas/laminas-session` `^2.16.0` and `mezzio/mezzio-template` `^2.8.0`.

### Added

- Tests, Psalm and the coding standard checks.

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 3.3.0 - 2023-03-29

### Changed

- Nothing

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- The `laminas/laminas-dependency-plugin` requirement.

### Fixed

- Nothing

## 3.2.0 - 2022-05-03

### Changed

- Updated PHP version to allow exactly 8.0 and 8.1

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 3.1.0 - 2020-11-03

### Changed

- Composer 2 compatibility.
- Update composer.json to require version 2 of laminas/laminas-dependency-plugin to be Composer 2 compatible.

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 3.0.3 - 2020-09-09

### Changed

- composer.json

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 3.0.2 - 2020-09-09

### Changed

- composer.json

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- extra keyword from composer.json

### Fixed

- Nothing

## 3.0.1 - 2020-04-23

### Changed

- Updated to newer packages of phpunit/phpunit and squizlabs/php_codesniffer

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Noting

### Fixed

- Nothing

## 3.0 - 2020-04-16

### Changed

- Php version required to 7.4

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Noting

### Fixed

- Nothing

## 2.0.0 - 2020-01-30

### Changed

- Laminas and Mezzio migration.

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Support

### Fixed

- Nothing

## 1.0.0 - 2018-05-04

Migration to Zend Expressive 3

### Changed

- Using `dot-session` version ^3.0

### Added

- Support for Zend Expressive 3

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 0.2.0 - 2017-03-15

### Changed

- Updated factories to use PSR11 container

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 0.1.1 - 2017-03-11

Updated php file headers doc blocks

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 0.1.0 - 2017-03-08

Initial tagged release

### Added

- Everything

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing
