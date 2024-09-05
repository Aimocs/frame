<?php

namespace App\EventListener;

use followed\framed\Http\Event\ResponseEvent;

class InternalErrorListener
{
    private const INTERNAL_ERROR_MIN_VALUE= 499;
    public function __invoke(ResponseEvent $event): void
    {
        // TODO: Implement __invoke() method.
        $status = $event->getResponse()->getStatus();
        if($status > self::INTERNAL_ERROR_MIN_VALUE){
            $event->stopPropagation();
        }
    }
}