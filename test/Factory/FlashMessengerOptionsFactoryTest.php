<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Factory;

use Dot\FlashMessenger\Factory\FlashMessengerOptionsFactory;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use DotTest\FlashMessenger\CommonTrait;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FlashMessengerOptionsFactoryTest extends TestCase
{
    use CommonTrait;

    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testCreateFlashMessengerOptionsWithDefaultConfig(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())
            ->method('get')
            ->willReturn($this->config);

        $result = (new FlashMessengerOptionsFactory())($container);
        $this->assertInstanceOf(FlashMessengerOptions::class, $result);
    }
}
