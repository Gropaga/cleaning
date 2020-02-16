<?php

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Command\Client;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateClientCommand extends Command
{
    use HandleTrait;

    protected static $defaultName = 'app:create-client';

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus, SerializerInterface $serializer)
    {
        parent::__construct();
        $this->messageBus = $commandBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world');
    }
}
