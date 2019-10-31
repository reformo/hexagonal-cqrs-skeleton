<?php

declare(strict_types=1);

namespace Reformo\Common\Interfaces;

interface Email
{
    public static function createFromString(string $email) : Email;

    public function toString() : string;
}
