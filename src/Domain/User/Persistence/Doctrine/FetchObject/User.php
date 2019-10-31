<?php
declare(strict_types=1);

namespace Reformo\Domain\User\Persistence\Doctrine\FetchObject;

use Reformo\Common\Abstracts\FetchCustomObject;

class User
{
    use FetchCustomObject;
    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $createdAt;
}