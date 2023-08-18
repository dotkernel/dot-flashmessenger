<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessengerInterface;
use Mezzio\Template\TemplateRendererInterface;

use function array_merge;

class FlashMessengerRenderer implements RendererInterface
{
    protected TemplateRendererInterface $template;

    protected FlashMessengerInterface $flashMessenger;

    public function __construct(TemplateRendererInterface $template, FlashMessengerInterface $flashMessenger)
    {
        $this->template       = $template;
        $this->flashMessenger = $flashMessenger;
    }

    public function render(
        string $template,
        array $params = [],
        ?string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): string {
        $messages = $this->flashMessenger->getMessages($type, $channel);

        return $this->template->render(
            $template,
            array_merge(
                ['messages' => $messages, 'messenger' => $this->flashMessenger, 'renderer' => $this],
                $params
            )
        );
    }

    public function renderPartial(
        string $partial,
        array $params = [],
        ?string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ): string {
        $messages = $this->flashMessenger->getMessages($type, $channel);

        return $this->template->render(
            $partial,
            array_merge(
                ['messages' => $messages, 'messenger' => $this->flashMessenger, 'renderer' => $this],
                $params
            )
        );
    }
}
