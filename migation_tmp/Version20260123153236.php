<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260123153236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC46B51E5C FOREIGN KEY (manekineko_id) REFERENCES manekineko (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manekineko ADD nom VARCHAR(255) NOT NULL');
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
        $this->addSql('ALTER TABLE manekineko DROP nom');
    }
}
