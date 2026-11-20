<?php

declare(strict_types=1);

namespace Dot\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessengerInterface;
use Mezzio\Template\TemplateRendererInterface;

use function array_merge;
use function htmlspecialchars;
use function is_array;
use function is_string;

use const ENT_QUOTES;
use const ENT_SUBSTITUTE;

class FlashMessengerRenderer implements RendererInterface
{
    public function __construct(
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $flashMessenger
    ) {
    }

    /**
     * Render the messages as HTML lists, one list for each message type. All messages are escaped.
     */
    public function render(?string $type = null, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL): string
    {
        $messages = $this->flashMessenger->getMessages($type, $channel);
        if ($type !== null) {
            return $this->renderList($type, $messages);
        }

        $html = '';
        foreach ($messages as $messageType => $list) {
            if (is_array($list)) {
                $html .= $this->renderList((string) $messageType, $list);
            }
        }

        return $html;
    }

    /**
     * @param non-empty-string $partial
     * @param array<non-empty-string, mixed> $params
     */
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

    /**
     * @param array<array-key, mixed> $messages
     */
    private function renderList(string $type, array $messages): string
    {
        $items = '';
        foreach ($messages as $message) {
            if (is_string($message)) {
                $items .= '<li>' . $this->escape($message) . '</li>';
            }
        }
        if ($items === '') {
            return '';
        }

        return '<ul class="flash-messages flash-messages-' . $this->escape($type) . '">' . $items . '</ul>';
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
