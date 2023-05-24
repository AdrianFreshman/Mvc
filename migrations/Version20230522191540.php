<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522140200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE effekt_av_covid19 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, total_deaths INTEGER NOT NULL, male_deaths INTEGER NOT NULL, female_deaths INTEGER NOT NULL, under_50 INTEGER NOT NULL, age_50_59 INTEGER NOT NULL, age_60_69 INTEGER NOT NULL, under_70 INTEGER NOT NULL, age_70_74 INTEGER NOT NULL, age_75_79 INTEGER NOT NULL, age_80_84 INTEGER NOT NULL, age_85_89 INTEGER NOT NULL, age_85_plus INTEGER NOT NULL, age_90_plus INTEGER NOT NULL, cardiovascular_disease INTEGER NOT NULL, high_blood_pressure INTEGER NOT NULL, diabetes INTEGER NOT NULL, lung_disease INTEGER NOT NULL, no_disease_group INTEGER NOT NULL, one_disease_group INTEGER NOT NULL, multiple_disease_groups INTEGER NOT NULL, special_housing INTEGER NOT NULL, home_care INTEGER NOT NULL, hospital_deaths INTEGER NOT NULL, special_housing_deaths INTEGER NOT NULL, ordinary_housing_deaths INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        
        // Additional migration
        $this->addSql('CREATE TABLE boende (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vecka INTEGER NOT NULL, twthousandsixteen NUMERIC(4, 1) NOT NULL, twothousandseventeen NUMERIC(4, 1) NOT NULL, twothousandeighteen NUMERIC(4, 1) NOT NULL, twothousandnineteen NUMERIC(4, 1) NOT NULL, twothousandtwenty NUMERIC(4, 1) NOT NULL)');
        
        // Add the migration code from Version20230523134514.php
        $this->addSql('CREATE TABLE unemployement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, age_range VARCHAR(10) NOT NULL, age2018 DOUBLE PRECISION NOT NULL, age2019 DOUBLE PRECISION NOT NULL, age2020 DOUBLE PRECISION NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE effekt_av_covid19');
        $this->addSql('DROP TABLE library');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE messenger_messages');
        
        // Additional migration
        $this->addSql('DROP TABLE boende');
        
        // Add the down() migration code from Version20230523134514.php
        $this->addSql('DROP TABLE unemployement');
    }
}