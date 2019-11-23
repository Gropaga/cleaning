<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191122143123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init EventStore';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
    CREATE TABLE "public"."event_store" (
      "id" uuid NOT NULL,
      "aggregate_id" uuid NOT NULL,
      "event_name" varchar(512) NOT NULL,
      "created_at" timestamp(6) NOT NULL,
      "payload" text,
      PRIMARY KEY ("id")
                                        );
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
    DROP TABLE "public"."event_store";
SQL
        );
    }
}
