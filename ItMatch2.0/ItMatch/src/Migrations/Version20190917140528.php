<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190917140528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet ADD conducteur_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C24F8F475 FOREIGN KEY (conducteur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98C24F8F475 ON trajet (conducteur_id_id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE filename filename VARCHAR(255) NOT NULL, CHANGE updated_at upfileat DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C24F8F475');
        $this->addSql('DROP INDEX IDX_2B5BA98C24F8F475 ON trajet');
        $this->addSql('ALTER TABLE trajet DROP conducteur_id_id');
        $this->addSql('ALTER TABLE utilisateur CHANGE filename filename VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE upfileat updated_at DATETIME NOT NULL');
    }
}
