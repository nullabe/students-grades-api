<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210127201113 extends AbstractMigration
{
    public function isTransactional(): bool
    {
        return false;
    }

    public function getDescription() : string
    {
        return 'Grade doctrine model';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE grades (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, value NUMERIC(10, 0) NOT NULL, INDEX IDX_3AE36110CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grades ADD CONSTRAINT FK_3AE36110CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE grades');
    }
}
