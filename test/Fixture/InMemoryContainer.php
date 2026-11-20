<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Fixture;

use Closure;
use Psr\Container\ContainerInterface;

use function array_key_exists;

/**
 * A minimal PSR-11 container for tests. A Closure entry is a factory that receives the container.
 */
final class InMemoryContainer implements ContainerInterface
{
    /**
     * @param array<string, mixed> $services
     */
    public function __construct(private array $services = [])
    {
    }

    public function get(string $id): mixed
    {
        if (! $this->has($id)) {
            throw new ServiceNotFoundException($id);
        }

        $service = $this->services[$id];

        return $service instanceof Closure ? $service($this) : $service;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}
