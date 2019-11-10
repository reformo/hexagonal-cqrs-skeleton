<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Command;

use Reformo\Common\Exception\InvalidArgument;
use function array_keys;
use function in_array;
use function sprintf;

class UpdateUserPartially
{
    private $id;
    private $payload            = [];
    private static $validFields = ['first_name', 'last_name', 'email'];

    public function __construct(string $uuid, array $payload)
    {
        foreach (array_keys($payload) as $fieldName) {
            if (! in_array($fieldName, self::$validFields)) {
                throw InvalidArgument::create(sprintf('Invalid field used to update user: %s', $fieldName));
            }
        }
        $this->payload = $payload;
        $this->id      = $uuid;
    }

    public function id()
    {
        return $this->id;
    }

    public function payload()
    {
        return $this->payload;
    }
}
