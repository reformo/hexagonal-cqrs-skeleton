<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Command;

class UnregisterUser
{
    private $id;

    public function __construct(string $uuid)
    {
        $this->id = $uuid;
    }

    public function id()
    {
        return $this->id;
    }
}
