<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014202011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE party_user (party_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9230179A213C1059 (party_id), INDEX IDX_9230179AA76ED395 (user_id), PRIMARY KEY(party_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE party_user ADD CONSTRAINT FK_9230179A213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE party_user ADD CONSTRAINT FK_9230179AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE party ADD organisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0D936B2FA FOREIGN KEY (organisateur_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_89954EE0D936B2FA ON party (organisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE party_user');
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE0D936B2FA');
        $this->addSql('DROP INDEX IDX_89954EE0D936B2FA ON party');
        $this->addSql('ALTER TABLE party DROP organisateur_id');
    }
}
