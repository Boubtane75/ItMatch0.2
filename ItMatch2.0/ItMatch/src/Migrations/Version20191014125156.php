<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014125156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, author VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, created_ad DATETIME NOT NULL, INDEX IDX_9474526CD12A823 (trajet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, nom_hobby VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobby_utilisateur (hobby_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_69AFDD28322B2123 (hobby_id), INDEX IDX_69AFDD28FB88E14F (utilisateur_id), PRIMARY KEY(hobby_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, conducteur_id_id INT NOT NULL, lieu_depart VARCHAR(255) NOT NULL, lieu_arrived VARCHAR(255) NOT NULL, heure_depart DATETIME NOT NULL, INDEX IDX_2B5BA98C24F8F475 (conducteur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_utilisateur (trajet_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_ED0C1620D12A823 (trajet_id), INDEX IDX_ED0C1620FB88E14F (utilisateur_id), PRIMARY KEY(trajet_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, upfileat DATETIME NOT NULL, roles JSON NOT NULL, INDEX IDX_1D1C63B3C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE hobby_utilisateur ADD CONSTRAINT FK_69AFDD28322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hobby_utilisateur ADD CONSTRAINT FK_69AFDD28FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C24F8F475 FOREIGN KEY (conducteur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE trajet_utilisateur ADD CONSTRAINT FK_ED0C1620D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_utilisateur ADD CONSTRAINT FK_ED0C1620FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C3C6F69F');
        $this->addSql('ALTER TABLE hobby_utilisateur DROP FOREIGN KEY FK_69AFDD28322B2123');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD12A823');
        $this->addSql('ALTER TABLE trajet_utilisateur DROP FOREIGN KEY FK_ED0C1620D12A823');
        $this->addSql('ALTER TABLE hobby_utilisateur DROP FOREIGN KEY FK_69AFDD28FB88E14F');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C24F8F475');
        $this->addSql('ALTER TABLE trajet_utilisateur DROP FOREIGN KEY FK_ED0C1620FB88E14F');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE hobby_utilisateur');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE trajet_utilisateur');
        $this->addSql('DROP TABLE utilisateur');
    }
}
