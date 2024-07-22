<?php

namespace followed\framed\Routing;
use followed\framed\Http\Request;
interface RouterInterface
{
    public function dispatch(Request $request);
}