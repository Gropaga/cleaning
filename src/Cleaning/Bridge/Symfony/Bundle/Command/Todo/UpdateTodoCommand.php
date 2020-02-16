<?php

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Command\Todo;

use CleaningCRM\Cleaning\Application\Todo\Command\Update;
use CleaningCRM\Cleaning\Application\Todo\Dto\TodoDto;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateTodoCommand extends Command
{
    protected static $defaultName = 'app:update-todo';

    private MessageBusInterface $bus;

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
        $todo->date = DateTimeImmutable::createFromFormat('Y-m-d', '1987-12-06')->setTime(0, 0);

        $this->bus->dispatch(new Update($todoId, $todo));

        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }
}
