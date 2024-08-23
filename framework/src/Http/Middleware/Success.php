<?php 

namespace followed\framed\Http\Middleware;

use followed\framed\Http\Request;
use followed\framed\Http\Response;

class Success implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        return new Response('OMG it worked!!', 200);
    }
}