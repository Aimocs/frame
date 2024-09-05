<?php

namespace followed\framed\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements  EventDispatcherInterface
{
    private iterable $listeners = [];
    public function dispatch(object $event)
    {
        foreach($this->getListenersForEvent($event) as $listener){
            if($event instanceof StoppableEventInterface && $event->isPropagationStopped()){
                return $event;
            }
            $listener($event);
        }
        return $event;
    }

    public function getListenersForEvent(object $event):iterable
    {
        $eventName = get_class($event);
        if(array_key_exists($eventName,$this->listeners)){
            return $this->listeners[$eventName];
        }
        return [];
    }

    public function addListener(string $eventName, callable $listener): self
    {
        $this->listeners[$eventName][] = $listener;
        return $this;
    }
}