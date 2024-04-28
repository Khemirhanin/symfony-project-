<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240428180350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipes (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, time INT NOT NULL, nb_servings SMALLINT NOT NULL, difficulty VARCHAR(60) NOT NULL, ingredients VARCHAR(60) DEFAULT NULL, description VARCHAR(2000) DEFAULT NULL, confirm SMALLINT NOT NULL, average_rating DOUBLE PRECISION DEFAULT NULL, INDEX IDX_A369E2B579F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B579F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipes DROP FOREIGN KEY FK_A369E2B579F37AE5');
        $this->addSql('DROP TABLE recipes');
    }
}
