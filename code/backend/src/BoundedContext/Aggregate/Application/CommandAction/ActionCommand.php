<?php

declare(strict_types=1);

namespace App\BoundedContext\Aggregate\Application\CommandAction;

use App\Shared\Domain\Bus\Command\Command;

final readonly class ActionCommand implements Command
{

    public function __construct(
        public string $argument
    ){}
}