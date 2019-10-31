<?php

declare(strict_types=1);

namespace Reformo\Application;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Zend\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ExampleException extends DomainException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    private const STATUS = 403;
    private const TYPE   = 'https://example.com/problems/insufficient-funds';
    private const TITLE  = 'You have insufficient funds to complete the transaction.';

    private function __construct(int $status, string $detail, string $title, string $type, array $additional)
    {
        $this->status     = $status;
        $this->detail     = $detail;
        $this->title      = $title;
        $this->type       = $type;
        $this->additional = $additional;
        parent::__construct($detail, $status);
    }

    public static function create(?array $additional = []) : self
    {
        return new self(self::STATUS, 'Failed', self::TITLE, self::TYPE, $additional);
    }
}
