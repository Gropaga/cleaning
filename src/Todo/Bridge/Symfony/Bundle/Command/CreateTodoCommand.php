<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\Command;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class CreateTodoCommand extends Command
{
    protected static $defaultName = 'app:create-todo';

    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        parent::__construct();
        $this->bus = $bus;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $todoId = TodoId::generate();

        $newTodo = new TodoDto();

        $newTodo->title = 'Title goes here';
        $newTodo->description = 'Some description is here';
        $newTodo->date = DateTimeImmutable::createFromFormat('Y-m-d', '2000-01-11');

        $this->bus->dispatch(new Create($todoId, $newTodo));

        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }
}
