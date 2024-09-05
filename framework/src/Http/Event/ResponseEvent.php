<?php

namespace followed\framed\Http\Event;

use followed\framed\EventDispatcher\Event;
use followed\framed\Http\Request;
use followed\framed\Http\Response;

class ResponseEvent extends Event
{
    public function __construct(
        private Request $request,
        private Response $response
    )
    {

    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

}