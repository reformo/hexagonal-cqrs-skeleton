<?php

declare(strict_types=1);

namespace Reformo\Common\Services;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;
use function ngettext;

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
            new TwigFunction('translate', 'gettext'),
            new TwigFunction('plural', [$this, 'translatePlural']),
         //   new TwigFunction('yourFunction', [$this, 'methodName']),
        ];
    }

    public function getFilters()
    {
        return [
            //  new TwigFilter('yourFilter', [$this, 'methodName']),
        ];
    }

    public function translatePlural($messageId, $number)
    {
        return ngettext($messageId, $messageId . '_PLURAL', $number);
    }
}
