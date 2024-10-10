<?php

declare(strict_types=1);

namespace App\BoundedContext\Aggregate\Application\CommandAction;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ActionCommandHandler
{
    public function __construct(
        private Action $action,
    ) {
    }

    public function __invoke(ActionCommand $command): void
    {
        ($this->action)(argument: $command->argument);
    }
}
