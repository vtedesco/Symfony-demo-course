<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240906160637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news ADD COLUMN views INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__news AS SELECT id, title, short_desc, content, insert_date, picture FROM news');
        $this->addSql('DROP TABLE news');
        $this->addSql('CREATE TABLE news (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, short_desc CLOB DEFAULT NULL, content CLOB DEFAULT NULL, insert_date DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO news (id, title, short_desc, content, insert_date, picture) SELECT id, title, short_desc, content, insert_date, picture FROM __temp__news');
        $this->addSql('DROP TABLE __temp__news');
    }
}
