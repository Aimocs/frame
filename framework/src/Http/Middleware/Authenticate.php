<?php // framework/src/Http/Middleware/Authenticate.php

namespace followed\framed\Http\Middleware;

use followed\framed\Authentication\SessionAuthentication;
use followed\framed\Http\RedirectResponse;
use followed\framed\Http\Request;
use followed\framed\Http\Response;
use followed\framed\Session\Session;
use followed\framed\Session\SessionInterface;

class Authenticate implements MiddlewareInterface
{
    private bool $authenticated = true;

    public function __construct(private SessionInterface $session)
    {

    }
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();
        if (!$this->session->has(Session::AUTH_KEY)) {
            $this->session->setFlash("error", "Sign In");
            return new RedirectResponse("/login");

        }
        return $requestHandler->handle($request);
    }
}