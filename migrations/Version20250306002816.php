<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306002816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE author (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book (id INT NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, population INT NOT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B0234F92F3E70 ON city (country_id)');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, alpha2 VARCHAR(2) NOT NULL, alpha3 VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE interest (id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE profile (id INT NOT NULL, country_id INT DEFAULT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, avatar_id INT DEFAULT NULL, gender INT DEFAULT NULL, status INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FE7927C74 ON profile (email)');
        $this->addSql('CREATE INDEX IDX_8157AA0FF92F3E70 ON profile (country_id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F8BAC62AF ON profile (city_id)');
        $this->addSql('CREATE TABLE profile_book (id INT NOT NULL, profile_id INT DEFAULT NULL, book_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7D2D2CA5CCFA12B8 ON profile_book (profile_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D2D2CA516A2B381 ON profile_book (book_id)');
        $this->addSql('CREATE TABLE profile_interest (id INT NOT NULL, profile_id INT NOT NULL, interest_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_95547BD6CCFA12B8 ON profile_interest (profile_id)');
        $this->addSql('CREATE INDEX IDX_95547BD65A95FF89 ON profile_interest (interest_id)');
        $this->addSql('CREATE TABLE profile_programming_language (id INT NOT NULL, profile_id INT NOT NULL, programming_language_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_45A404F2CCFA12B8 ON profile_programming_language (profile_id)');
        $this->addSql('CREATE INDEX IDX_45A404F2A2574C1E ON profile_programming_language (programming_language_id)');
        $this->addSql('CREATE TABLE programming_language (id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_book ADD CONSTRAINT FK_7D2D2CA5CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_book ADD CONSTRAINT FK_7D2D2CA516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_interest ADD CONSTRAINT FK_95547BD6CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_interest ADD CONSTRAINT FK_95547BD65A95FF89 FOREIGN KEY (interest_id) REFERENCES interest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_programming_language ADD CONSTRAINT FK_45A404F2CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_programming_language ADD CONSTRAINT FK_45A404F2A2574C1E FOREIGN KEY (programming_language_id) REFERENCES programming_language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql("INSERT INTO author(id, name, surname)
                VALUES 
                (1, 'William', 'Shakespeare'),
                (2, 'Charles', 'Dickens'),
                (3, 'Jane', 'Austen'),
                (4, 'Mark', 'Twain'),
                (5, 'Herman', 'Melville'),
                (6, 'Virginia', 'Woolf'),
                (7, 'George', 'Orwell'),
                (8, 'Stephen', 'King');");

        $this->addSql("INSERT INTO country 
            VALUES 
            (1, 'United States of America', 'us', 'usa'),
            (2, 'Argentina', 'ar', 'arg'),
            (3, 'Belgium', 'bl', 'bel'),
            (4, 'China', 'cn', 'chn'),
            (5, 'Colombia', 'cl', 'col'),
            (6, 'Cyprus', 'cp', 'cyp');
            ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE profile DROP CONSTRAINT FK_8157AA0FF92F3E70');
        $this->addSql('ALTER TABLE profile DROP CONSTRAINT FK_8157AA0F8BAC62AF');
        $this->addSql('ALTER TABLE profile_book DROP CONSTRAINT FK_7D2D2CA5CCFA12B8');
        $this->addSql('ALTER TABLE profile_book DROP CONSTRAINT FK_7D2D2CA516A2B381');
        $this->addSql('ALTER TABLE profile_interest DROP CONSTRAINT FK_95547BD6CCFA12B8');
        $this->addSql('ALTER TABLE profile_interest DROP CONSTRAINT FK_95547BD65A95FF89');
        $this->addSql('ALTER TABLE profile_programming_language DROP CONSTRAINT FK_45A404F2CCFA12B8');
        $this->addSql('ALTER TABLE profile_programming_language DROP CONSTRAINT FK_45A404F2A2574C1E');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE interest');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_book');
        $this->addSql('DROP TABLE profile_interest');
        $this->addSql('DROP TABLE profile_programming_language');
        $this->addSql('DROP TABLE programming_language');
    }
}
