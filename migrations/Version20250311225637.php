<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250311225637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, population INT NOT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B0234F92F3E70 ON city (country_id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
//        $this->addSql('ALTER TABLE book ALTER author_id DROP NOT NULL');
//        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD birth_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FE7927C74 ON profile (email)');
        $this->addSql('CREATE INDEX IDX_8157AA0F8BAC62AF ON profile (city_id)');
        $this->addSql('DROP INDEX uniq_2d5b0234f92f3e70');
        $this->addSql('CREATE INDEX IDX_2D5B0234F92F3E70 ON city (country_id)');

        $this->addSql("INSERT INTO city 
            VALUES 
            (1, 1, 'Washington', 600000, true),
            (2, 2, 'Buenos Aires', 3000000, true),
            (3, 3, 'Brussels', 200000, true),
            (4, 4, 'Beijing', 22000000, true),
            (5, 5, 'Bogota', 7900000, true),
            (6, 6, 'Limassol', 108000, true);
            ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA citus');
        $this->addSql('CREATE SCHEMA citus_internal');
        $this->addSql('CREATE SCHEMA columnar');
        $this->addSql('CREATE SCHEMA columnar_internal');
        $this->addSql('ALTER TABLE profile DROP CONSTRAINT FK_8157AA0F8BAC62AF');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE columnar_internal.storageid_seq INCREMENT BY 1 MINVALUE 10000000000 START 10000000000');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234F92F3E70');
        $this->addSql('DROP TABLE city');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE book ALTER author_id SET NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8157AA0FE7927C74');
        $this->addSql('DROP INDEX IDX_8157AA0F8BAC62AF');
        $this->addSql('ALTER TABLE profile DROP city_id');
        $this->addSql('ALTER TABLE profile DROP birth_date');
    }
}
