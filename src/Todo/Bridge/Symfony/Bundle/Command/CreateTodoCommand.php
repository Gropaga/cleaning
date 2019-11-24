<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\Command;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use CleaningCRM\Todo\Domain\Model\TodoId;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

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

        $newTodo->description = 'New todo';

        $this->bus->dispatch(new Create($todoId, $newTodo));

        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }
}
