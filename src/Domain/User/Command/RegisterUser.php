<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Command;

class RegisterUser
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;

    public function __construct(string $uuid, string $firstName, string $lastName, string $email)
    {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
        $this->id        = $uuid;
    }

    public function id()
    {
        return $this->id;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function email()
    {
        return $this->email;
    }
}
