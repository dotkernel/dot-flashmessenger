# Overview

`dot-flashmessenger` is a library for session messages between redirects.

A flash message, or session message, is a piece of text that is available only in the next request.

The library also keeps other session data, not only text messages, with the same behavior.

With the flash messenger, you add data to the session and get it back in the next request. You do not set and clear the data yourself.

The factories use only `Psr\Container\ContainerInterface`. They work with any PSR-11 container that accepts a factory for each service.

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
