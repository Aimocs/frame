<?php // framework/src/Http/Middleware/Authenticate.php

namespace followed\framed\Http\Middleware;

use followed\framed\Http\Request;
use followed\framed\Http\Response;

class Authenticate implements MiddlewareInterface
{
    private bool $authenticated = true;

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        if (!$this->authenticated) {
            return new Response('Authentication failed', 401);
        }
        return $requestHandler->handle($request);
    }
}