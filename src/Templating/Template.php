<?php

declare(strict_types=1);

namespace Hoop\Templating;

interface Template
{
    public function render(string $template, array $data = []): string;
}