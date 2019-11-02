<?php

declare(strict_types=1);

namespace Reformo\Common\Util;

use League\Tactician\CommandBus as TacticianCommandBus;

class MessageBus
{
    private $messageBus;

    public function __construct(TacticianCommandBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function handle(object $command)
    {
        return $this->messageBus->handle($command);
    }
}
