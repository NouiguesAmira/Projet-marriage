<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112184211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, nom_s VARCHAR(255) NOT NULL, adresse_s VARCHAR(255) NOT NULL, capasite_s INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invite (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invite_mariage (invite_id INT NOT NULL, mariage_id INT NOT NULL, INDEX IDX_301F60D6EA417747 (invite_id), INDEX IDX_301F60D6192813B (mariage_id), PRIMARY KEY(invite_id, mariage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mariage (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, date_mariage DATE NOT NULL, INDEX IDX_2FE8EC22A21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom_p VARCHAR(255) NOT NULL, prenom_p VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invite_mariage ADD CONSTRAINT FK_301F60D6EA417747 FOREIGN KEY (invite_id) REFERENCES invite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invite_mariage ADD CONSTRAINT FK_301F60D6192813B FOREIGN KEY (mariage_id) REFERENCES mariage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mariage ADD CONSTRAINT FK_2FE8EC22A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invite_mariage DROP FOREIGN KEY FK_301F60D6EA417747');
        $this->addSql('ALTER TABLE invite_mariage DROP FOREIGN KEY FK_301F60D6192813B');
        $this->addSql('ALTER TABLE mariage DROP FOREIGN KEY FK_2FE8EC22A21BD112');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE invite');
        $this->addSql('DROP TABLE invite_mariage');
        $this->addSql('DROP TABLE mariage');
        $this->addSql('DROP TABLE personne');
    }
}
