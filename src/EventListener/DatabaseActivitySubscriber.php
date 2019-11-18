<?php

namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

class DatabaseActivitySubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            ToolEvents::postGenerateSchema,
            Events::loadClassMetadata
        ];
    }

    public function loadClassMetadata(GenerateSchemaEventArgs $args): void
    {
        $schema = $args->getSchema();
        $tinkLog = $schema->createTable('tink_log');
        $tinkLog->addColumn('id', 'uuid');
        $tinkLog->addColumn('client_id', 'integer');
        $tinkLog->addColumn('response', 'text')->setNotnull(false);
        $tinkLog->addColumn('error', 'boolean')->setNotnull(false);
        $tinkLog->setPrimaryKey(['id']);
    }
}
