<?php

declare(strict_types=1);

namespace Reformo\Common;

use Dotenv\Dotenv;
use function getcwd;

class DotEnvConfigProvider
{
    public function __invoke() : array
    {
        $dotenv = Dotenv::create(getcwd());
        $dotenv->load();
        return [];
    }
}
