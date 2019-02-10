<?php

declare(strict_types=1);

namespace Hoop\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;

final class DoctrineDbalDatabaseFactory
{
    private $params;

    public function __construct(array $DatabaseParams)
    {
        $this->params = $DatabaseParams;
    }

    public function create()
    {
        $config = new Configuration();
        $connection = DriverManager::getConnection($this->params, $config);

        return new DoctrineDbalDatabase($connection);
    }
}