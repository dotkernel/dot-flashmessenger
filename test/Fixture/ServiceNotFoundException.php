<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Fixture;

use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

use function sprintf;

final class ServiceNotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('The service "%s" is not in the container.', $id));
    }
}
