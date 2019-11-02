<?php

declare(strict_types=1);

namespace Reformo\Common\Util;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
    private $globals;

    public function __construct(?array $globals = [])
    {
        $this->globals = $globals;
    }

    public function getGlobals() : array
    {
        return $this->globals;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions() : array
    {
        return [
         //   new TwigFunction('yourFunction', [$this, 'methodName']),
        ];
    }
}
