<?php

declare(strict_types=1);

namespace App\BoundedContext\Aggregate\Presentation\Command;

use App\BoundedContext\Aggregate\Application\CommandAction\ActionCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:action', description: 'Do action')]
class ActionCliCommand extends Command
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Do action');
        $this->addArgument('argument', InputArgument::REQUIRED, 'description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $argument = $input->getArgument('argument');

        $output->writeln('Hello ' . $argument);

        $this->commandBus->dispatch(new ActionCommand(argument:$argument));

        return Command::SUCCESS;
    }

    private function readCsvRows($csvFile): iterable
    {
        while (($data = fgetcsv($csvFile, null, ';')) !== false) {
            yield $data;
        }
    }
}
