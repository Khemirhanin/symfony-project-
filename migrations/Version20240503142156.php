<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503142156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, recipe_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, rate SMALLINT DEFAULT NULL, INDEX IDX_6970EB0FA76ED395 (user_id), INDEX IDX_6970EB0F59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id)');
        $this->addSql('ALTER TABLE recipes ADD id_user_id INT DEFAULT NULL, ADD image VARCHAR(255) NOT NULL, CHANGE ingredients ingredients VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B579F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_A369E2B579F37AE5 ON recipes (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F59D8A214');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('ALTER TABLE recipes DROP FOREIGN KEY FK_A369E2B579F37AE5');
        $this->addSql('DROP INDEX IDX_A369E2B579F37AE5 ON recipes');
        $this->addSql('ALTER TABLE recipes DROP id_user_id, DROP image, CHANGE ingredients ingredients VARCHAR(60) DEFAULT NULL');
    }
}
