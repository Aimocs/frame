<?php

namespace followed\framed\Http\Middleware;

use followed\framed\Authentication\SessionAuthentication;
use followed\framed\Http\RedirectResponse;
use followed\framed\Http\Request;
use followed\framed\Http\Response;
use followed\framed\Session\Session;
use followed\framed\Session\SessionInterface;

class Guest  implements MiddlewareInterface
{

    public function __construct(private SessionInterface $session)
    {

    }
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();

        if ($this->session->has(Session::AUTH_KEY)) {
            return new RedirectResponse('/dash');
        }

        return $requestHandler->handle($request);
    }
}