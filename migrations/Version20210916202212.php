<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916202212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `message` (id INT AUTO_INCREMENT NOT NULL, sender INT DEFAULT NULL, receiver INT DEFAULT NULL, message VARCHAR(350) NOT NULL, is_read TINYINT(1) NOT NULL, date_add DATETIME NOT NULL, INDEX IDX_B6BD307F5F004ACF (sender), INDEX IDX_B6BD307F3DB88C96 (receiver), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `message` ADD CONSTRAINT FK_B6BD307F5F004ACF FOREIGN KEY (sender) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `message` ADD CONSTRAINT FK_B6BD307F3DB88C96 FOREIGN KEY (receiver) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `message`');
    }
}
