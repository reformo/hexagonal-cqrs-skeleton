<?php
declare(strict_types=1);

namespace Reformo\Common;

use Dotenv\Dotenv;

class DotEnvConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        $dotenv = Dotenv::create(getcwd());
        $dotenv->load();
        return [
        ];
    }


}
