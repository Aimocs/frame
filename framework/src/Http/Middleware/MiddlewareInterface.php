<?php

namespace followed\framed\Http\Middleware;

use followed\framed\Http\Request;
use followed\framed\Http\Response;

interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response;
}