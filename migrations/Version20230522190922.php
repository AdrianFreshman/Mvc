<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522190922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boende (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vecka INTEGER NOT NULL, twthousandsixteen NUMERIC(4, 1) NOT NULL, twothousandseventeen NUMERIC(4, 1) NOT NULL, twothousandeighteen NUMERIC(4, 1) NOT NULL, twothousandnineteen NUMERIC(4, 1) NOT NULL, twothousandtwenty NUMERIC(4, 1) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boende');
    }
}
