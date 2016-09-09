<?php
/**
 * Created by PhpStorm.
 * User: n3vra
 * Date: 6/11/2016
 * Time: 6:06 PM
 */

namespace DotKernel\DotFlashMessenger;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FlashMessengerMiddleware
 * @package DotKernel\DotFlashMessenger
 */
class FlashMessengerMiddleware
{
    /** @var FlashMessengerInterface  */
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