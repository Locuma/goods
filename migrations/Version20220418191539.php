<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418191539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bundle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bundle_goods (bundle_id INT NOT NULL, goods_id INT NOT NULL, INDEX IDX_9E3B0C86F1FAD9D3 (bundle_id), INDEX IDX_9E3B0C86B7683595 (goods_id), PRIMARY KEY(bundle_id, goods_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goods (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bundle_goods ADD CONSTRAINT FK_9E3B0C86F1FAD9D3 FOREIGN KEY (bundle_id) REFERENCES bundle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bundle_goods ADD CONSTRAINT FK_9E3B0C86B7683595 FOREIGN KEY (goods_id) REFERENCES goods (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messenger_messages CHANGE queue_name queue_name VARCHAR(190) NOT NULL');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bundle_goods DROP FOREIGN KEY FK_9E3B0C86F1FAD9D3');
        $this->addSql('ALTER TABLE bundle_goods DROP FOREIGN KEY FK_9E3B0C86B7683595');
        $this->addSql('DROP TABLE bundle');
        $this->addSql('DROP TABLE bundle_goods');
        $this->addSql('DROP TABLE goods');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0 ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE ON messenger_messages');
    }
}
