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
        $this->addSql("
            
            CREATE SEQUENCE author_id_seq START 1;
            ALTER TABLE author ALTER COLUMN id SET DEFAULT nextval('author_id_seq');
            CREATE SEQUENCE book_id_seq START 1;
            ALTER TABLE book ALTER COLUMN id SET DEFAULT nextval('book_id_seq');
        ");

        $this->addSql('DROP INDEX uniq_2d5b0234f92f3e70');
        $this->addSql('CREATE INDEX IDX_2D5B0234F92F3E70 ON city (country_id)');
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
