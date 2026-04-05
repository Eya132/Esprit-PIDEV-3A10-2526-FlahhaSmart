<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260401122435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31686B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('DROP INDEX reference ON commandes');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires CHANGE id_commentaire id_commentaire INT NOT NULL, CHANGE id_thread id_thread INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE contenu contenu LONGTEXT NOT NULL, CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE statut statut VARCHAR(10) NOT NULL, CHANGE sentiment sentiment VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C41717F96E FOREIGN KEY (id_thread) REFERENCES threads (id_thread) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C46B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consommation_produit CHANGE id_produit id_produit INT NOT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consommation_produit ADD CONSTRAINT FK_F2D81B36B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jaime CHANGE id_jaime id_jaime INT NOT NULL, CHANGE id_thread id_thread INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE date_jaime date_jaime DATETIME NOT NULL');
        $this->addSql('ALTER TABLE jaime ADD CONSTRAINT FK_3CB778051717F96E FOREIGN KEY (id_thread) REFERENCES threads (id_thread) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jaime ADD CONSTRAINT FK_3CB778056B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notifications CHANGE id_notif id_notif INT NOT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE lu lu TINYINT NOT NULL, CHANGE date_notif date_notif DATETIME NOT NULL');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D36B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('DROP INDEX reputation_ibfk_1 ON reputation');
        $this->addSql('ALTER TABLE reputation CHANGE id_rep id_rep INT NOT NULL, CHANGE points points INT NOT NULL, CHANGE badge badge VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE stock_produit CHANGE id_produit id_produit INT NOT NULL, CHANGE date_fin_estimee date_fin_estimee DATE NOT NULL, CHANGE statut statut VARCHAR(50) NOT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock_produit ADD CONSTRAINT FK_3003FC846B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE threads CHANGE id_thread id_thread INT NOT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE contenu contenu LONGTEXT NOT NULL, CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL, CHANGE statut statut VARCHAR(10) NOT NULL, CHANGE sentiment sentiment VARCHAR(10) NOT NULL, CHANGE tags tags VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDD6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE todo ADD id INT NOT NULL, CHANGE NomTache nom_tache VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX email ON users');
        $this->addSql('ALTER TABLE users CHANGE id_user id_user INT NOT NULL, CHANGE prenom prenom VARCHAR(100) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE ville ville VARCHAR(100) NOT NULL, CHANGE photo_profil photo_profil VARCHAR(255) NOT NULL, CHANGE role role VARCHAR(255) NOT NULL, CHANGE actif actif TINYINT NOT NULL, CHANGE date_creation date_creation DATETIME NOT NULL');
        $this->addSql('DROP INDEX votes_ibfk_2 ON votes');
        $this->addSql('DROP INDEX unique_vote ON votes');
        $this->addSql('ALTER TABLE votes CHANGE id_vote id_vote INT NOT NULL, CHANGE id_thread id_thread INT DEFAULT NULL, CHANGE date_vote date_vote DATETIME NOT NULL');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF1717F96E FOREIGN KEY (id_thread) REFERENCES threads (id_thread) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_518B7ACF1717F96E ON votes (id_thread)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31686B3CA4B');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C6B3CA4B');
        $this->addSql('CREATE UNIQUE INDEX reference ON commandes (reference)');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C41717F96E');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C46B3CA4B');
        $this->addSql('ALTER TABLE commentaires CHANGE id_commentaire id_commentaire INT AUTO_INCREMENT NOT NULL, CHANGE contenu contenu TEXT NOT NULL, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE statut statut VARCHAR(10) DEFAULT \'actif\', CHANGE sentiment sentiment VARCHAR(10) DEFAULT \'neutre\', CHANGE id_thread id_thread INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE consommation_produit DROP FOREIGN KEY FK_F2D81B36B3CA4B');
        $this->addSql('ALTER TABLE consommation_produit CHANGE id_produit id_produit INT AUTO_INCREMENT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE jaime DROP FOREIGN KEY FK_3CB778051717F96E');
        $this->addSql('ALTER TABLE jaime DROP FOREIGN KEY FK_3CB778056B3CA4B');
        $this->addSql('ALTER TABLE jaime CHANGE id_jaime id_jaime INT AUTO_INCREMENT NOT NULL, CHANGE date_jaime date_jaime DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE id_thread id_thread INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D36B3CA4B');
        $this->addSql('ALTER TABLE notifications CHANGE id_notif id_notif INT AUTO_INCREMENT NOT NULL, CHANGE lu lu TINYINT DEFAULT 0, CHANGE date_notif date_notif DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE reputation CHANGE id_rep id_rep INT AUTO_INCREMENT NOT NULL, CHANGE points points INT DEFAULT 0, CHANGE badge badge VARCHAR(20) DEFAULT \'? Débutant\'');
        $this->addSql('CREATE INDEX reputation_ibfk_1 ON reputation (id_user)');
        $this->addSql('ALTER TABLE stock_produit DROP FOREIGN KEY FK_3003FC846B3CA4B');
        $this->addSql('ALTER TABLE stock_produit CHANGE id_produit id_produit INT AUTO_INCREMENT NOT NULL, CHANGE date_fin_estimee date_fin_estimee DATE DEFAULT NULL, CHANGE statut statut VARCHAR(50) DEFAULT \'en cours\' NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE threads DROP FOREIGN KEY FK_6F8E3DDD6B3CA4B');
        $this->addSql('ALTER TABLE threads CHANGE id_thread id_thread INT AUTO_INCREMENT NOT NULL, CHANGE contenu contenu TEXT NOT NULL, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE statut statut VARCHAR(10) DEFAULT \'actif\', CHANGE sentiment sentiment VARCHAR(10) DEFAULT \'neutre\', CHANGE tags tags VARCHAR(500) DEFAULT \'\', CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE todo DROP id, CHANGE nom_tache NomTache VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (NomTache)');
        $this->addSql('ALTER TABLE users CHANGE id_user id_user INT AUTO_INCREMENT NOT NULL, CHANGE prenom prenom VARCHAR(100) DEFAULT NULL, CHANGE telephone telephone VARCHAR(20) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(100) DEFAULT NULL, CHANGE photo_profil photo_profil VARCHAR(255) DEFAULT NULL, CHANGE role role ENUM(\'ADMINISTRATEUR\', \'AGRICULTEUR\', \'CLIENT\') NOT NULL, CHANGE actif actif TINYINT DEFAULT 1, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX email ON users (email)');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF1717F96E');
        $this->addSql('DROP INDEX IDX_518B7ACF1717F96E ON votes');
        $this->addSql('ALTER TABLE votes CHANGE id_vote id_vote INT AUTO_INCREMENT NOT NULL, CHANGE date_vote date_vote DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id_thread id_thread INT NOT NULL');
        $this->addSql('CREATE INDEX votes_ibfk_2 ON votes (id_user)');
        $this->addSql('CREATE UNIQUE INDEX unique_vote ON votes (id_thread, id_user)');
    }
}
