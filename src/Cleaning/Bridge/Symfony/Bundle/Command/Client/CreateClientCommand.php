<?php

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Command\Client;

use JMS\Serializer\SerializerInterface;
use MongoDB\Database;
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
    private SerializerInterface $serializer;
    private Database $db;

    public function __construct(MessageBusInterface $commandBus, SerializerInterface $serializer, Database $db)
    {
        parent::__construct();
        $this->messageBus = $commandBus;
        $this->serializer = $serializer;
        $this->db = $db;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $collection = $this->db->selectCollection('users');

        $insertOneResult = $collection->insertOne([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'name' => 'Admin User',
        ]);

        printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

        var_dump($insertOneResult->getInsertedId());
    }
}
