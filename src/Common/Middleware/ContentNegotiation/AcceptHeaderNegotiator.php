<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware\ContentNegotiation;

use function count;
use function explode;

class AcceptHeaderNegotiator
{
    private $priorities;
    private $clientPriorities = [];

    private function __construct()
    {
    }

    public static function createFromAcceptHeader(string $acceptHeaderString, ?array $priorities = null) : self
    {
        $acceptHeader             = new self();
        $acceptHeader->priorities = $priorities;
        $acceptHeader->setPriorities($acceptHeaderString);

        return $acceptHeader;
    }

    private function setPriorities(string $acceptHeaderString) : void
    {
        $clientPriorities = explode(',', $acceptHeaderString);
        foreach ($clientPriorities as $priority) {
            $this->clientPriorities[] = AcceptHeaderPriority::createFromString($priority);
        }
    }

    public function getBest() : AcceptHeaderPriority
    {
        if ($this->priorities === null || count($this->priorities) === 0) {
            return $this->clientPriorities[0];
        }
    }
}
