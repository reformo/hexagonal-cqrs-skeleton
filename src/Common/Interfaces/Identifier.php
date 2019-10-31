<?php

declare(strict_types=1);

namespace Reformo\Common\Interfaces;

use Ramsey\Uuid\UuidInterface;
use Reformo\Domain\User\Interfaces\UserId;

interface Identifier
{
    public static function createFromString(string $uuid) : UserId;

    public function id() : UuidInterface;

    public function toString() : string;
}
