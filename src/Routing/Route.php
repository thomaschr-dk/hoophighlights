<?php

declare(strict_types=1);

namespace Hoop\Routing;

final class Route
{
    private $status;
    private $handler;
    private $vars;

    public function __construct(int $status, string $handler = null, array $vars = null)
    {
        $this->status = $status;
        $this->handler = $handler;
        $this->vars = $vars;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getVars(): array
    {
        return $this->vars;
    }
}