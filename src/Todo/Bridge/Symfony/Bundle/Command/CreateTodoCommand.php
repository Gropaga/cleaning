<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\Command;

use CleaningCRM\Common\Domain\Interval;
use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateTodoCommand extends Command
{
    use HandleTrait;

    protected static $defaultName = 'app:create-todo';

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        parent::__construct();
        $this->messageBus = $commandBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $todoId = TodoId::generate();

        $todoDto = new TodoDto();
        $todoDto->completed = false;
        $todoDto->interval = Interval::create(
            DateTimeImmutable::createFromFormat('Y-m-d', '2000-01-11'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2000-01-11')
        );
        $todoDto->description = 'Some description is here';
        $todoDto->title = 'Title goes here';

        $this->handle(new Create(
            $todoId,
            $todoDto
        ));

        $output->writeln('New Todo '.$todoId);
    }
}
