<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009073251 extends AbstractMigration
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
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, conducteur_id_id INT NOT NULL, lieu_depart VARCHAR(255) NOT NULL, lieu_arrived VARCHAR(255) NOT NULL, heure_depart DATETIME NOT NULL, heure_arrived DATETIME NOT NULL, INDEX IDX_2B5BA98C24F8F475 (conducteur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, upfileat DATETIME NOT NULL, INDEX IDX_1D1C63B3C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_trajet (utilisateur_id INT NOT NULL, trajet_id INT NOT NULL, INDEX IDX_4AF69307FB88E14F (utilisateur_id), INDEX IDX_4AF69307D12A823 (trajet_id), PRIMARY KEY(utilisateur_id, trajet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C24F8F475 FOREIGN KEY (conducteur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE utilisateur_trajet ADD CONSTRAINT FK_4AF69307FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_trajet ADD CONSTRAINT FK_4AF69307D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C3C6F69F');
        $this->addSql('ALTER TABLE utilisateur_trajet DROP FOREIGN KEY FK_4AF69307D12A823');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C24F8F475');
        $this->addSql('ALTER TABLE utilisateur_trajet DROP FOREIGN KEY FK_4AF69307FB88E14F');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_trajet');
    }
}
