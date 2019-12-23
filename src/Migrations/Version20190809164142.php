<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190809164142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, publisher_id INT NOT NULL, nom VARCHAR(128) DEFAULT NULL, prenom VARCHAR(128) DEFAULT NULL, ville VARCHAR(128) NOT NULL, telephone INT NOT NULL, projet LONGTEXT DEFAULT NULL, INDEX IDX_C744045540C86FCE (publisher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dispo (id INT AUTO_INCREMENT NOT NULL, id_dispo INT NOT NULL, jour DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magasin (id INT AUTO_INCREMENT NOT NULL, publisher_id INT NOT NULL, nom_magasin VARCHAR(128) NOT NULL, adresse VARCHAR(128) NOT NULL, ville VARCHAR(128) NOT NULL, telephone INT NOT NULL, projet LONGTEXT DEFAULT NULL, INDEX IDX_54AF5F2740C86FCE (publisher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom INT NOT NULL, service_nom INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, client_email_id INT NOT NULL, dispo_iddispo_id INT NOT NULL, magasin_nom_id INT NOT NULL, nom INT NOT NULL, prix INT DEFAULT NULL, is_validated VARCHAR(255) DEFAULT NULL, INDEX IDX_E19D9AD286D4F10C (client_email_id), INDEX IDX_E19D9AD2402ED4EA (dispo_iddispo_id), INDEX IDX_E19D9AD270FBD6E8 (magasin_nom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045540C86FCE FOREIGN KEY (publisher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F2740C86FCE FOREIGN KEY (publisher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD286D4F10C FOREIGN KEY (client_email_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2402ED4EA FOREIGN KEY (dispo_iddispo_id) REFERENCES dispo (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD270FBD6E8 FOREIGN KEY (magasin_nom_id) REFERENCES magasin (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD286D4F10C');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2402ED4EA');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD270FBD6E8');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045540C86FCE');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F2740C86FCE');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE dispo');
        $this->addSql('DROP TABLE magasin');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
    }
}
