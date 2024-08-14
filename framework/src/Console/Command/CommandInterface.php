<?php 

namespace followed\framed\Console\Command;

interface CommandInterface
{
    public function execute(array $params = []): int;
}
