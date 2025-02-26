<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226021554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            INSERT INTO author(id, name, surname)
                VALUES 
                (1, 'William', 'Shakespeare'),
                (2, 'Charles', 'Dickens'),
                (3, 'Jane', 'Austen'),
                (4, 'Mark', 'Twain'),
                (5, 'Herman', 'Melville'),
                (6, 'Virginia', 'Woolf'),
                (7, 'George', 'Orwell'),
                (8, 'Stephen', 'King');
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
