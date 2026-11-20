<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Factory;

use Dot\FlashMessenger\Factory\FlashMessengerRendererFactory;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use DotTest\FlashMessenger\Fixture\InMemoryContainer;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;

class FlashMessengerRendererFactoryTest extends TestCase
{
    public function testCreateFlashMessengerRenderer(): void
    {
        $container = new InMemoryContainer([
            TemplateRendererInterface::class => $this->createStub(TemplateRendererInterface::class),
            FlashMessengerInterface::class   => $this->createStub(FlashMessengerInterface::class),
        ]);

        $result = (new FlashMessengerRendererFactory())($container);

        $this->assertSame(FlashMessengerRenderer::class, $result::class);
    }
}
