<?php
declare(strict_types=1);

namespace CWStorage;

class Application
{
    public function __invoke(): void
    {
        echo 'Hello!';
        exit;
    }
}

