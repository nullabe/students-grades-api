<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210126212042 extends AbstractMigration
{
    public function isTransactional(): bool
    {
        return false;
    }

    public function getDescription() : string
    {
        return 'Student doctrine model';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_A4698DB2D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE students');
    }
}
