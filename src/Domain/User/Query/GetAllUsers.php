<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Query;

class GetAllUsers
{
    private $offset = 0;
    private $limit  = 25;

    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit  = $limit;
    }

    public function offset() : int
    {
        return $this->offset;
    }

    public function limit() : int
    {
        return $this->limit;
    }
}
