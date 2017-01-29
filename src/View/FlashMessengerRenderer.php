<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

declare(strict_types=1);

namespace Dot\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessengerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class FlashMessengerRenderer
 * @package Dot\FlashMessenger\View
 */
class FlashMessengerRenderer implements RendererInterface
{
    /** @var TemplateRendererInterface */
    protected $template;

    /** @var FlashMessengerInterface */
    protected $flashMessenger;

    /**
     * FlashMessengerRenderer constructor.
     * @param TemplateRendererInterface $template
     * @param FlashMessengerInterface $flashMessenger
     */
    public function __construct(TemplateRendererInterface $template, FlashMessengerInterface $flashMessenger)
    {
        $this->template = $template;
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @param null|string $type
     * @param string $channel
     * @return string
     */
    public function render(string $type = null, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL) : string
    {
        //TODO: implement a default html rendering of the messages
        return '';
    }

    /**
     * @param string $partial
     * @param array $params
     * @param string|null $type
     * @param string $channel
     * @return string
     */
    public function renderPartial(
        string $partial,
        array $params = [],
        string $type = null,
        string $channel = FlashMessengerInterface::DEFAULT_CHANNEL
    ) : string {
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
