<?php

declare(strict_types=1);

namespace Reformo\Common\Middleware\ContentNegotiation;

use function array_pop;
use function explode;
use function property_exists;
use function str_ireplace;
use function stripos;
use function strpos;

class AcceptHeaderPriority
{
    private $type       = 'application/json';
    private $charset    = 'UTF-8';
    private $q          = 1.0;
    private $parameters = [];
    private $version;

    private function __construct()
    {
    }

    public static function createFromString(string $priority) : self
    {
        $acceptHeaderPriority = new self();
        $acceptHeaderPriority->parsePriorityString($priority);

        return $acceptHeaderPriority;
    }

    private function parsePriorityString(string $priority) : void
    {
        $parts = explode(';', $priority);
        foreach ($parts as $part) {
            $this->checkAcceptType($part);
            $this->setParameters($part);
        }
    }

    private function checkAcceptType(string $acceptType) : void
    {
        if (strpos($acceptType, '/') === false) {
            return;
        }
        $this->type = $acceptType === '*/*' ? 'application/json' : $acceptType;
        $this->checkVersionInAcceptType($acceptType);
    }

    private function checkVersionInAcceptType(string $acceptType) : void
    {
        $subParts = explode('/', $acceptType);
        if (strpos($subParts[1], '.') === false) {
            return;
        }
        $subPartDetails = explode('.', $subParts[1]);
        $versionPart    = array_pop($subPartDetails);
        if (stripos($versionPart, 'v') === false) {
            return;
        }
        if (stripos($versionPart, '+') !== false) {
            [$versionPart] = explode('+', $versionPart);
        }
        $this->version = str_ireplace('v', '', $versionPart);
    }

    private function setParameters(string $acceptParameter) : void
    {
        if (strpos($acceptParameter, '=') === false) {
            return;
        }
        [$parameter, $value] = explode('=', $acceptParameter);
        if (! property_exists($this, $parameter)) {
            $this->parameters[$parameter] = $value;

            return;
        }
        $this->{$parameter} = $parameter === 'q' ? (float) $value : $value;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function charset() : string
    {
        return $this->charset;
    }

    public function version() : ?string
    {
        return $this->version;
    }

    public function quality() : float
    {
        return $this->q;
    }

    public function parameters() : array
    {
        return $this->parameters;
    }
}
