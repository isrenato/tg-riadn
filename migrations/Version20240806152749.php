<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240806152749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, processed TINYINT(1) NOT NULL, telegram_user_id INT NOT NULL, INDEX IDX_5E9E89CBFC28B263 (telegram_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE telegram_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(64) NOT NULL, telegram_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F180F059CC0B3066 (telegram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBFC28B263 FOREIGN KEY (telegram_user_id) REFERENCES telegram_user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBFC28B263');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE telegram_user');
    }
}
