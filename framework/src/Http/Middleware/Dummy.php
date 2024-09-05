<?php

namespace followed\framed\Http\Middleware;



use followed\framed\Http\Request;
use followed\framed\Http\Response;

class Dummy implements  MiddlewareInterface
{

    public function process( Request $request , RequestHandlerInterface $requestHandler): Response
    {
        return $requestHandler->handle($request);
    }
}