<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\Command;

use CleaningCRM\Common\Domain\EventPublisher;
use CleaningCRM\Common\Domain\Interval;
use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use CleaningCRM\Todo\Bridge\Symfony\Bundle\IntegrationEvents\PublishEvents;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class CreateTodoCommand extends Command
{
    protected static $defaultName = 'app:create-todo';

    private $repository;
    private $publishEvents;

    public function __construct(TodoRepository $repository, EventPublisher $publishEvents)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->publishEvents = $publishEvents;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $todo = Todo::create(
            TodoId::generate(),
            'Title goes here',
            'Some description is here',
            Interval::create(
                DateTimeImmutable::createFromFormat('Y-m-d', '2000-01-11'),
                DateTimeImmutable::createFromFormat('Y-m-d', '2000-01-11')
            ),
            false
        );

        $this->publishEvents->add($todo);

        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }
}
