<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009075554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, author VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, created_ad DATETIME NOT NULL, INDEX IDX_9474526CD12A823 (trajet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passager (id INT AUTO_INCREMENT NOT NULL, passager_id INT DEFAULT NULL, INDEX IDX_BFF42EE971A51189 (passager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_passager (trajet_id INT NOT NULL, passager_id INT NOT NULL, INDEX IDX_E8EE2CCDD12A823 (trajet_id), INDEX IDX_E8EE2CCD71A51189 (passager_id), PRIMARY KEY(trajet_id, passager_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE passager ADD CONSTRAINT FK_BFF42EE971A51189 FOREIGN KEY (passager_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE trajet_passager ADD CONSTRAINT FK_E8EE2CCDD12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_passager ADD CONSTRAINT FK_E8EE2CCD71A51189 FOREIGN KEY (passager_id) REFERENCES passager (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet_passager DROP FOREIGN KEY FK_E8EE2CCD71A51189');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE passager');
        $this->addSql('DROP TABLE trajet_passager');
        $this->addSql('ALTER TABLE utilisateur DROP roles');
    }
}
