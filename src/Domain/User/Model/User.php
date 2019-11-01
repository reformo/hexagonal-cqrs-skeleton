<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Model;

use DateTimeImmutable;
use Reformo\Common\Interfaces\Email as EmailInterface;
use Reformo\Common\ValueObject\Email;
use Reformo\Domain\User\Exception\InvalidFirstName;
use Reformo\Domain\User\Interfaces\UserId as UserIdInterface;
use Throwable;
use Webmozart\Assert\Assert;

class User
{
    public const CREATED_AT_FORMAT = 'Y-m-d H:i:s';

    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $createdAt;

    private function __construct(
        UserIdInterface $id,
        EmailInterface $email,
        string $firstName,
        string $lastName,
        DateTimeImmutable $createdAt
    ) {
        $this->id        = $id;
        $this->email     = $email;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->createdAt = $createdAt;
    }

    public static function create(string $uuid, string $email, string $firstName, string $lastName, string $createdAt)
    {
        try {
            Assert::minLength($firstName, 2, 'First name must be at least 2 characters long');
        } catch (Throwable $exception) {
            throw InvalidFirstName::create($exception->getMessage());
        }
        try {
            Assert::minLength($lastName, 2, 'Last name must be at least 2 characters long');
        } catch (Throwable $exception) {
            throw InvalidFirstName::create($exception->getMessage());
        }

        return new self(
            UserId::createFromString($uuid),
            Email::createFromString($email),
            $firstName,
            $lastName,
            DateTimeImmutable::createFromFormat(self::CREATED_AT_FORMAT, $createdAt)
        );
    }

    public function id() : UserIdInterface
    {
        return $this->id;
    }

    public function email() : EmailInterface
    {
        return $this->email;
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function lastName() : string
    {
        return $this->lastName;
    }

    public function createdAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }
}
