<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226021533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE author_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE author (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
        $this->addSql('ALTER TABLE profile_book DROP CONSTRAINT FK_7D2D2CA516A2B381');
        $this->addSql('DROP INDEX idx_7d2d2ca516a2b381');
        $this->addSql('ALTER TABLE profile_book ALTER profile_id DROP NOT NULL');
        $this->addSql('ALTER TABLE profile_book ALTER book_id DROP NOT NULL');
        $this->addSql('ALTER TABLE profile_book ADD CONSTRAINT FK_7D2D2CA516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D2D2CA516A2B381 ON profile_book (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331F675F31B');
        $this->addSql('DROP SEQUENCE author_id_seq CASCADE');
        $this->addSql('DROP TABLE author');
        $this->addSql('ALTER TABLE profile_book DROP CONSTRAINT fk_7d2d2ca516a2b381');
        $this->addSql('DROP INDEX UNIQ_7D2D2CA516A2B381');
        $this->addSql('ALTER TABLE profile_book ALTER profile_id SET NOT NULL');
        $this->addSql('ALTER TABLE profile_book ALTER book_id SET NOT NULL');
        $this->addSql('ALTER TABLE profile_book ADD CONSTRAINT fk_7d2d2ca516a2b381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7d2d2ca516a2b381 ON profile_book (book_id)');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B');
    }
}
