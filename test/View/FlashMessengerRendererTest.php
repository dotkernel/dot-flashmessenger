<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use DotTest\FlashMessenger\CommonTrait;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;

class FlashMessengerRendererTest extends TestCase
{
    use CommonTrait;

    private function messengerWithMessages(): FlashMessenger
    {
        $sessionManager = $this->createSessionManager();
        $options        = ['namespace' => 'dot_messenger', 'session_manager' => $sessionManager];

        $previous = new FlashMessenger($options);
        $previous->addError(['<b>bold</b>', 'second error'], 'test-channel');
        $previous->addInfo('info & more', 'test-channel');

        return new FlashMessenger($options);
    }

    public function testRenderPartialSendsMessagesAndParamsToTheTemplate(): void
    {
        $flashMessenger = $this->messengerWithMessages();
        $template       = $this->createMock(TemplateRendererInterface::class);
        $subject        = new FlashMessengerRenderer($template, $flashMessenger);

        $template->expects($this->once())
            ->method('render')
            ->with('partial::messages', [
                'messages'    => ['<b>bold</b>', 'second error'],
                'messenger'   => $flashMessenger,
                'renderer'    => $subject,
                'dismissible' => true,
            ])
            ->willReturn('html');

        $this->assertSame(
            'html',
            $subject->renderPartial('partial::messages', ['dismissible' => true], 'error', 'test-channel')
        );
    }

    public function testRenderEscapesAllMessagesOfTheChannel(): void
    {
        $subject = new FlashMessengerRenderer(
            $this->createStub(TemplateRendererInterface::class),
            $this->messengerWithMessages()
        );

        $this->assertSame(
            '<ul class="flash-messages flash-messages-error"><li>&lt;b&gt;bold&lt;/b&gt;</li><li>second error</li></ul>'
            . '<ul class="flash-messages flash-messages-info"><li>info &amp; more</li></ul>',
            $subject->render(null, 'test-channel')
        );
    }

    public function testRenderOneType(): void
    {
        $subject = new FlashMessengerRenderer(
            $this->createStub(TemplateRendererInterface::class),
            $this->messengerWithMessages()
        );

        $this->assertSame(
            '<ul class="flash-messages flash-messages-info"><li>info &amp; more</li></ul>',
            $subject->render(FlashMessengerInterface::INFO, 'test-channel')
        );
    }

    public function testRenderWithoutMessagesReturnsAnEmptyString(): void
    {
        $subject = new FlashMessengerRenderer(
            $this->createStub(TemplateRendererInterface::class),
            $this->messengerWithMessages()
        );

        $this->assertSame('', $subject->render());
        $this->assertSame('', $subject->render(FlashMessengerInterface::WARNING, 'test-channel'));
    }
}
