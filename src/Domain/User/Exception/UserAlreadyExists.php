<?php

declare(strict_types=1);

namespace Reformo\Domain\User\Exception;

use Exception;
use Reformo\Domain\DomainException;
use Zend\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class UserAlreadyExists extends Exception implements ProblemDetailsExceptionInterface
{
    use DomainException;

    private const STATUS = 409;
    private const CODE   = 'USER-1000';
    private const TYPE   = 'https://httpstatus.es/409';
    private const TITLE  = 'User Not Found';
}
