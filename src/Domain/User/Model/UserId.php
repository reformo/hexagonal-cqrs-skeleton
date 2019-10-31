<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Model;

use Reformo\Common\IdentifierTrait;
use Reformo\Domain\User\Interfaces\UserId as UserIdInterface;

class UserId implements UserIdInterface
{
    use IdentifierTrait;
}
