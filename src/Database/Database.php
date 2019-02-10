<?php

declare(strict_types=1);

namespace Hoop\Database;

interface Database
{
    public function find(int $id, string $tableName): ?array;

    public function findAll(string $tableName, array $params = null): ?array;

    public function findBy(string $tableName, array $params = null): ?array;

    public function update(string $tableName, array $data, array $identifier): int;
}