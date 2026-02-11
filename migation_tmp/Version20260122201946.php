<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260122201946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, comment LONGTEXT NOT NULL, manekineko_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_67F068BC46B51E5C (manekineko_id), INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE fabriquant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE manekineko (id INT AUTO_INCREMENT NOT NULL, auteur VARCHAR(255) NOT NULL, date_fabrication DATE DEFAULT NULL, nom_fabriquant VARCHAR(255) DEFAULT NULL, estimation INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, user_id INT NOT NULL, fabriquant_id INT NOT NULL, INDEX IDX_A8940E61A76ED395 (user_id), INDEX IDX_A8940E615E0C7E7D (fabriquant_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC46B51E5C FOREIGN KEY (manekineko_id) REFERENCES manekineko (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manekineko ADD CONSTRAINT FK_A8940E61A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manekineko ADD CONSTRAINT FK_A8940E615E0C7E7D FOREIGN KEY (fabriquant_id) REFERENCES fabriquant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC46B51E5C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE manekineko DROP FOREIGN KEY FK_A8940E61A76ED395');
        $this->addSql('ALTER TABLE manekineko DROP FOREIGN KEY FK_A8940E615E0C7E7D');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE fabriquant');
        $this->addSql('DROP TABLE manekineko');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
