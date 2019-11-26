<?php

declare(strict_types=1);

namespace Reformo\Common\ValueObject\Interfaces;

interface Email
{
    public static function createFromString(string $email) : Email;

    public function toString() : string;
}
