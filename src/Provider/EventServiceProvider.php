<?php

namespace App\Provider;

use App\EventListener\ContentLengthListener;
use App\EventListener\InternalErrorListener;
use App\EventListener\SendEmail;
use followed\framed\Dbal\Event\PostPersist;
use followed\framed\EventDispatcher\EventDispatcher;
use followed\framed\Http\Event\ResponseEvent;
use followed\framed\ServiceProvider\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
    private array $listen =[
        ResponseEvent::class =>[
            InternalErrorListener::class,
            ContentLengthListener::class
        ],
        PostPersist::class=>[
            SendEmail::class
        ]
    ];
    public function __construct(private EventDispatcher $eventDispatcher)
    {
    }

    public function register(): void
    {
        foreach($this->listen as $eventName => $listeners){
            foreach(array_unique($listeners) as $listener){
                $this->eventDispatcher->addListener($eventName, new $listener);
            }
        }
    }
}