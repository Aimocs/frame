<?php // framework/src/Http/Middleware/requestHandlerInterface.php

namespace followed\framed\Http\Middleware;

use followed\framed\Http\Request;
use followed\framed\Http\Response;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}