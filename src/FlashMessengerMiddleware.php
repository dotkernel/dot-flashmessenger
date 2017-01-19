<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-flashmessenger
 * @author: n3vrax
 * Date: 9/6/2016
 * Time: 7:49 PM
 */

namespace Dot\FlashMessenger;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FlashMessengerMiddleware
 * @package Dot\FlashMessenger
 */
class FlashMessengerMiddleware
{
    /** @var FlashMessengerInterface */
    protected $flashMessenger;

    /**
     * FlashMessengerMiddleware constructor.
     * @param FlashMessengerInterface $flashMessenger
     */
    public function __construct(FlashMessengerInterface $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $request = $request->withAttribute(FlashMessengerInterface::class, $this->flashMessenger);
        return $next($request, $response);
    }
}
