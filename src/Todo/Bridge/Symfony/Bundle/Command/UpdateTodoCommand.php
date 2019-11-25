<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\Command;

use CleaningCRM\Todo\Application\Command\Todo\Update;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class UpdateTodoCommand extends Command
{
    protected static $defaultName = 'app:update-todo';

    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        parent::__construct();
        $this->bus = $bus;
    }

    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'Todo Id to update');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $todoId = TodoId::fromString($input->getArgument('id'));

        $todo = new TodoDto();

        $todo->title = 'Some title 123';
        $todo->description = 'Some description 000';
        $todo->date = DateTimeImmutable::createFromFormat('Y-m-d', '1987-12-06');

        $this->bus->dispatch(new Update($todoId, $todo));

        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }
}
