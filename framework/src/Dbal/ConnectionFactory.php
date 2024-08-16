<?php

namespace followed\framed\Dbal;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;

class ConnectionFactory
{
    public function __construct(private string $databaseUrl, private DsnParser $dsnParser)
    {
    }

    public function create(): Connection
    {
        $connectionParams = $this->dsnParser->parse($this->databaseUrl);
        return DriverManager::getConnection($connectionParams);
    }
}