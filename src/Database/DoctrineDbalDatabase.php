<?php

declare(strict_types=1);

namespace Hoop\Database;

use Doctrine\DBAL\Connection as DbalConnection;

final class DoctrineDbalDatabase implements Database
{
    private $connection;

    public function __construct(DbalConnection $connection)
    {
        $this->connection = $connection;
    }

    public function find(int $id, string $tableName): ?array
    {
        $this->checkConnection();

        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id = ?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return $result;
    }

    public function findAll(string $tableName, array $params = null): ?array
    {
        $this->checkConnection();

        $sql = 'SELECT * FROM ' . $tableName;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (!$result) {
            return null;
        }

        return $result;
    }

    public function findBy(string $tableName, array $params = null): ?array
    {
        $this->checkConnection();

        $sql = 'SELECT * FROM ' . $tableName . ' WHERE ';

        $i = 0;
        foreach ($params as $key => $val) {
            if ($i != 0) {
                $sql .= 'AND ';
            }
            $sql .= $key . ' = ? ';
            $i++;
        }
        echo $sql;
        $stmt = $this->connection->prepare($sql);

        $i = 1;
        foreach ($params as $param) {
            $stmt->bindValue($i, $param);
            $i++;
        }

        $stmt->execute();
        $result = $stmt->fetchAll();

        if (!$result) {
            return null;
        }

        return $result;
    }

    public function update(string $tableName, array $data, array $identifier): int
    {
        $this->checkConnection();

        return $this->connection->update($tableName, $data, $identifier);
    }

    private function checkConnection()
    {
        if (!$this->connection instanceof DbalConnection) {
            throw new \Exception('Connection to database has not been established');
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}