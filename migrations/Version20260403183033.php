<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260403183033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31686B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users DROP photo_profil, CHANGE id_user id_user INT AUTO_INCREMENT NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(20) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(100) DEFAULT NULL, CHANGE role role VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31686B3CA4B');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74 ON users');
        $this->addSql('ALTER TABLE users ADD photo_profil VARCHAR(255) NOT NULL, CHANGE id_user id_user INT NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE ville ville VARCHAR(100) NOT NULL, CHANGE role role VARCHAR(255) NOT NULL');
    }
}
