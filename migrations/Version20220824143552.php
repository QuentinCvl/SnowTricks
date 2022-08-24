<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824143552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_D8F0A91E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricks_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, detail LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricks_comment (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, user_id INT NOT NULL, parent_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_E12A4619B281BE2E (trick_id), INDEX IDX_E12A4619A76ED395 (user_id), UNIQUE INDEX UNIQ_E12A4619727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricks_images (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, src VARCHAR(255) NOT NULL, position INT DEFAULT NULL, INDEX IDX_D4A857A8B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricks_videos (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, src VARCHAR(255) NOT NULL, INDEX IDX_1D1D8DF0B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E12469DE2 FOREIGN KEY (category_id) REFERENCES tricks_category (id)');
        $this->addSql('ALTER TABLE tricks_comment ADD CONSTRAINT FK_E12A4619B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE tricks_comment ADD CONSTRAINT FK_E12A4619A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tricks_comment ADD CONSTRAINT FK_E12A4619727ACA70 FOREIGN KEY (parent_id) REFERENCES tricks_comment (id)');
        $this->addSql('ALTER TABLE tricks_images ADD CONSTRAINT FK_D4A857A8B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE tricks_videos ADD CONSTRAINT FK_1D1D8DF0B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks_comment DROP FOREIGN KEY FK_E12A4619B281BE2E');
        $this->addSql('ALTER TABLE tricks_images DROP FOREIGN KEY FK_D4A857A8B281BE2E');
        $this->addSql('ALTER TABLE tricks_videos DROP FOREIGN KEY FK_1D1D8DF0B281BE2E');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E12469DE2');
        $this->addSql('ALTER TABLE tricks_comment DROP FOREIGN KEY FK_E12A4619727ACA70');
        $this->addSql('ALTER TABLE tricks_comment DROP FOREIGN KEY FK_E12A4619A76ED395');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE tricks_category');
        $this->addSql('DROP TABLE tricks_comment');
        $this->addSql('DROP TABLE tricks_images');
        $this->addSql('DROP TABLE tricks_videos');
        $this->addSql('DROP TABLE user');
    }
}
