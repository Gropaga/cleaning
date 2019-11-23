<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191122155432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init Todo table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
    CREATE TABLE "public"."todo" (
      "id" uuid NOT NULL,
      "description" text,
      "completed" boolean,
      "created_at" timestamp,
      "updated_at" timestamp,
      PRIMARY KEY ("id")
                                        );
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
    DROP TABLE "public"."todo";
SQL
        );
    }
}
