<?php

declare(strict_types=1);

namespace Hoop\Repository;

interface Repository
{
    public function find(int $id);

    public function findAll();

    public function findBy(array $params);
}