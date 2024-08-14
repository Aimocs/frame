<?php 

namespace followed\framed\Console\Command;

class MigrateDatabase implements CommandInterface
{
    public string $name = 'database:migrations:migrate';

    public function execute(array $params = []): int
    {
        
        echo 'Executing MigrateDatabase command' . PHP_EOL;

        return 1;
    }
}
