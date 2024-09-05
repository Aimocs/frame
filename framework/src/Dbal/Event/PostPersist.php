<?php

namespace followed\framed\Dbal\Event;

use followed\framed\Dbal\Entity;
use followed\framed\EventDispatcher\Event;
use followed\framed\Http\Request;

class PostPersist extends  Event
{
    public function __construct(private Entity $subject, private Request $request)
    {

    }

    public function getSubject(): Entity
    {
        return $this->subject;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }


}