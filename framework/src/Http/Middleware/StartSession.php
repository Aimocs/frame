<?php 

namespace followed\framed\Http\Middleware;

use followed\framed\Http\Request;
use followed\framed\Http\Response;
use followed\framed\Session\SessionInterface;

class StartSession implements MiddlewareInterface
{
    public function __construct(private SessionInterface $session)
    {
    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();

        $request->setSession($this->session);

        return $requestHandler->handle($request);
    }
}