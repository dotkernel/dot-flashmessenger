<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Factory;

use Dot\FlashMessenger\Factory\FlashMessengerRendererFactory;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FlashMessengerRendererFactoryTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testCreateFlashMessengerRenderer(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap([
                [TemplateRendererInterface::class, $this->createMock(TemplateRendererInterface::class)],
                [FlashMessengerInterface::class, $this->createMock(FlashMessengerInterface::class)],
            ]);

        $result = (new FlashMessengerRendererFactory())($container);
        $this->assertInstanceOf(FlashMessengerRenderer::class, $result);
    }
}
