<?php

declare(strict_types=1);

namespace Reformo\Common\Abstracts;

use Reformo\Common\Exception\InvalidArgument;
use Selami\Stdlib\CaseConverter;
use function get_object_vars;
use function property_exists;
use function sprintf;

trait FetchCustomObject
{
    public function __set(string $name, $value) : void
    {
        $propertyName = CaseConverter::toCamelCase($name);
        if (! property_exists($this, $propertyName)) {
            throw InvalidArgument::create(
                sprintf(
                    'FetchCustomObject does not have property named: %s (%s).',
                    $propertyName,
                    $name
                )
            );
        }
        if ($this->{$propertyName} !== null) {
            throw InvalidArgument::create(
                sprintf(
                    'A value for the property (%s) has already been set.',
                    $propertyName
                )
            );
        }
        $this->{$propertyName} = $value;
    }

    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    public function __get($name)
    {
        if (! property_exists($this, $name)) {
            throw InvalidArgument::create(
                sprintf(
                    'This object does not have a property named: (%s)',
                    $name
                )
            );
        }

        return $this->{$name};
    }

    public function toArray() : array
    {
        $objectVars          = get_object_vars($this);
        $propertiesAsAnArray = [];
        foreach ($objectVars as $key => $value) {
            $propertiesAsAnArray[CaseConverter::toSnakeCase($key)] = $value;
        }

        return $propertiesAsAnArray;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
