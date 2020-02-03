<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191201163824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding soft delete column to todo';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
ALTER TABLE todo
ADD COLUMN deleted_at timestamp;
SQL
);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
ALTER TABLE todo
DROP COLUMN deleted_at;
SQL
);
    }
}
