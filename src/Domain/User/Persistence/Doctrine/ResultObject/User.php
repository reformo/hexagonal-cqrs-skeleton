<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\ResultObject;

use JsonSerializable;
use Reformo\Common\Services\Persistence\ResultObject;

class User implements JsonSerializable
{
    use ResultObject;

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
