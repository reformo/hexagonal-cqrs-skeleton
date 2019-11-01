<?php

declare(strict_types=1);

namespace Reformo\Common\Interfaces;

use Ramsey\Uuid\UuidInterface;

interface Identifier
{
    public static function createFromString(string $uuid) : Identifier;

    public function id() : UuidInterface;

    public function toString() : string;
}
