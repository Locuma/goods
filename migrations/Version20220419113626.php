<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419113626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A57B32FD5E237E06 ON bundle (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_563B92D5E237E06 ON goods (name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_A57B32FD5E237E06 ON bundle');
        $this->addSql('DROP INDEX UNIQ_563B92D5E237E06 ON goods');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0 ON messenger_messages');
    }
}
