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
      "title" text NOT NULL,
      "description" text,
      "date" timestamp NOT NULL,
      "completed" boolean NOT NULL,
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
