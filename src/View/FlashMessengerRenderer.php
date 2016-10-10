<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger\View;

use Dot\FlashMessenger\FlashMessengerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class FlashMessengerRenderer
 * @package Dot\FlashMessenger\View
 */
class FlashMessengerRenderer
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
     * @param null|string $namespace
     * @return string
     */
    public function renderMessages($namespace = null)
    {
        //TODO: implement a default html rendering of the messages
        return '';
    }

    /**
     * @param $partial
     * @param null|string $namespace
     * @param array $extra
     * @return string
     */
    public function renderPartial($partial, $namespace = null, array $extra = [])
    {
        $messages = $this->flashMessenger->getMessages($namespace);

        return $this->template->render($partial,
            array_merge(
                ['messages' => $messages, 'flashMessenger' => $this->flashMessenger, 'renderer' => $this],
                $extra));
    }
}