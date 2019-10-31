<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Exception;

use Exception;
use Reformo\Domain\DomainException;
use Zend\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class InvalidFirstName extends Exception implements ProblemDetailsExceptionInterface
{
    use DomainException;

    private const STATUS = 400;
    private const CODE   = 'USER-1001';
    private const TYPE   = 'https://httpstatus.es/400';
    private const TITLE  = 'Invalid first name.';
}
