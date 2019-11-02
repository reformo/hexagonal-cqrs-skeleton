<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\FetchObject;

use JsonSerializable;
use Reformo\Common\Abstracts\FetchCustomObject;

class User implements JsonSerializable
{
    use FetchCustomObject;

    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $createdAt;

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }
}
