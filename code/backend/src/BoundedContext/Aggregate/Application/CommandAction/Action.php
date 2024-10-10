<?php

declare(strict_types=1);

namespace App\BoundedContext\Aggregate\Application\CommandAction;

final readonly class Action{

    public function __invoke(
        string $argument
    ): void {
        dump('Hello ' . $argument);
    }
}