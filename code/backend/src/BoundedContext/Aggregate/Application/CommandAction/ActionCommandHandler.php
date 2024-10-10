<?php

declare(strict_types=1);

namespace App\BoundedContext\Aggregate\Application\CommandAction;

use App\Shared\Domain\Logging\LoggingInterface;
use App\Shared\Domain\Repository\TransactionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Exception;

#[AsMessageHandler]
final readonly class ActionCommandHandler
{
    public function __construct(
        private Action $action,
        private TransactionInterface $transaction,
        private LoggingInterface $logging
    ) {
    }

    public function __invoke(ActionCommand $command): void
    {
        $this->transaction->begin();
        try{
            ($this->action)(argument: $command->argument);
            $this->transaction->commit();
        } catch (Exception $e) {
            $this->transaction->rollback();
            $this->logging->error($e->getMessage());
        }
    }
}
