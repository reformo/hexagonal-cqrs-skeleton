<?php

declare(strict_types=1);

namespace Reformo\Common\MessageBus;

use League\Tactician\Handler\Mapping\ClassName\ClassNameInflector;

class CommandClassNameInflector implements ClassNameInflector
{
    public function getClassName(string $commandClassName) : string
    {
        return $commandClassName . 'Handler';
    }
}
