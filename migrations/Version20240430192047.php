<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430192047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipes ADD id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B579F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_A369E2B579F37AE5 ON recipes (id_user_id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipes DROP FOREIGN KEY FK_A369E2B579F37AE5');
        $this->addSql('DROP INDEX IDX_A369E2B579F37AE5 ON recipes');
        $this->addSql('ALTER TABLE recipes DROP id_user_id');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F59D8A214');
    }
}
