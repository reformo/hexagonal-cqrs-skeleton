<?php

declare(strict_types=1);

namespace Reformo\Common\ValueObject;

use Reformo\Common\ValueObject\Interfaces\Email as EmailInterface;
use Webmozart\Assert\Assert;

class Email implements EmailInterface
{
    private $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function createFromString(string $email) : EmailInterface
    {
        Assert::email($email, 'Invalid email address provided!');

        return new self($email);
    }

    public function toString() : string
    {
        return $this->email;
    }
}
