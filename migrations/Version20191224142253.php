<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191224142253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add start and end dates';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(<<<SQL
ALTER TABLE todo RENAME COLUMN date TO start;
SQL
        );

        $this->addSql(<<<SQL
ALTER TABLE todo
ADD COLUMN "end" timestamp;
SQL
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<SQL
ALTER TABLE todo
DROP COLUMN "end";
SQL
        );

        $this->addSql(<<<SQL
ALTER TABLE todo RENAME COLUMN start TO date;
SQL
        );
    }
}
