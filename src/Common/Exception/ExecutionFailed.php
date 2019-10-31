<?php

declare(strict_types=1);

namespace Reformo\Common\Exception;

use Exception;
use Reformo\Domain\DomainException;
use Zend\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ExecutionFailed extends Exception implements ProblemDetailsExceptionInterface
{
    use DomainException;

    private const STATUS = 500;
    private const CODE   = 'G-1001';
    private const TYPE   = 'https://httpstatus.es/500';
    private const TITLE  = 'Execution failed.';
}
