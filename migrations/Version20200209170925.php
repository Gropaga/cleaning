<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209170925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Client + Person';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
    CREATE TABLE "public"."client" (
      "id" uuid NOT NULL,
      "companyName" text,
      "contacts" json,
      "address" json,
      "vatNumber" text,
      "regNumber" text,
      "bankAccount" text,
      "liquidatedAt" timestamp,
      PRIMARY KEY ("id")
     );
SQL
        );

        $this->addSql(<<<SQL
    CREATE TABLE "public"."person" (
      "id" uuid NOT NULL,
      "name" json,
      "phone" text,
      "email" text,
      "address" text,
      "deletedAt" timestamp,
      PRIMARY KEY ("id")
     );
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
    DROP TABLE "public"."client";
SQL
        );

        $this->addSql(<<<SQL
    DROP TABLE "public"."contact";
SQL
        );
    }
}
