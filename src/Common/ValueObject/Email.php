<?php

declare(strict_types=1);

namespace Reformo\Common\ValueObject;

use Webmozart\Assert\Assert;

class Email
{
    private $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function createFromString(string $email) : self
    {
        Assert::email($email, 'Invalid email address provided!');

        return new self($email);
    }

    public function toString() : string
    {
        return $this->email;
    }
}
