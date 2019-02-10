<?php

declare(strict_types=1);

namespace Hoop\Routing;

use Symfony\Component\HttpFoundation\Request;

interface Router
{
    const NOT_FOUND = 0;
    const FOUND = 1;
    const METHOD_NOT_ALLOWED = 2;

    public function getRoutes(): array;

    public function dispatch(Request $request): Route;
}