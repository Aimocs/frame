<?php

namespace followed\framed\Dbal;

use Doctrine\DBAL\Connection;
use followed\framed\Dbal\Event\PostPersist;
use followed\framed\EventDispatcher\EventDispatcher;
use followed\framed\Http\Request;

class DataMapper
{
    public function __construct(
        private Connection $connection,
        private EventDispatcher $eventDispatcher
    )
    {
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function save(Entity $subject, Request $request) : int|string|null
    {
    $this->eventDispatcher->dispatch(new PostPersist($subject,$request));
    return $this->connection->lastInsertId();
    }
}