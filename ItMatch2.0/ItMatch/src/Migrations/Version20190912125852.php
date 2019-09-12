<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912125852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE utilisateur_trajet (utilisateur_id INT NOT NULL, trajet_id INT NOT NULL, INDEX IDX_4AF69307FB88E14F (utilisateur_id), INDEX IDX_4AF69307D12A823 (trajet_id), PRIMARY KEY(utilisateur_id, trajet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, lieu_depart VARCHAR(255) NOT NULL, lieu_arrived VARCHAR(255) NOT NULL, heure_depart DATETIME NOT NULL, heure_arrived DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_trajet ADD CONSTRAINT FK_4AF69307FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_trajet ADD CONSTRAINT FK_4AF69307D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur_trajet DROP FOREIGN KEY FK_4AF69307D12A823');
        $this->addSql('DROP TABLE utilisateur_trajet');
        $this->addSql('DROP TABLE trajet');
    }
}
