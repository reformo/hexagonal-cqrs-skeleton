<?php

declare(strict_types=1);

namespace Reformo\Common\Exception;

use InvalidArgumentException;
use Reformo\Domain\DomainException;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class InvalidArgument extends InvalidArgumentException implements ProblemDetailsExceptionInterface
{
    use DomainException;

    private const STATUS = 400;
    private const CODE   = 'G-1001';
    private const TYPE   = 'https://httpstatus.es/400';
    private const TITLE  = 'Invalid parameter.';
}
