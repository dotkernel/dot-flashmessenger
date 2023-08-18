<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class FlashMessengerRendererTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testWillRenderPartial(): void
    {
        $rendererInterface = $this->createMock(TemplateRendererInterface::class);
        $flashMessenger    = $this->createMock(FlashMessengerInterface::class);
        $flashMessenger->expects($this->once())
            ->method('getMessages')
            ->willReturn(['First error message', 'Second error message']);

        $subject = new FlashMessengerRenderer($rendererInterface, $flashMessenger);
        $html    = $subject->renderPartial('partial::test-partial', ['testParam'], 'error', 'test-channel');
        $this->assertIsString($html);
    }

    /**
     * @throws Exception
     */
    public function testWillRenderTemplate(): void
    {
        $rendererInterface = $this->createMock(TemplateRendererInterface::class);
        $flashMessenger    = $this->createMock(FlashMessengerInterface::class);
        $flashMessenger->expects($this->once())
            ->method('getMessages')
            ->willReturn(['First error message', 'Second error message']);

        $subject = new FlashMessengerRenderer($rendererInterface, $flashMessenger);
        $html    = $subject->render('templateRoot::template', ['testParam'], 'error', 'test-channel');
        $this->assertIsString($html);
    }
}
