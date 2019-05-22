<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190219092011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket CHANGE country country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation_ticket RENAME INDEX idx_f06caf700047d2 TO IDX_DF51E438B83297E7');
        $this->addSql('ALTER TABLE reservation_ticket RENAME INDEX idx_f06cafbad26311 TO IDX_DF51E438700047D2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE reservation_ticket RENAME INDEX idx_df51e438b83297e7 TO IDX_F06CAF700047D2');
        $this->addSql('ALTER TABLE reservation_ticket RENAME INDEX idx_df51e438700047d2 TO IDX_F06CAFBAD26311');
        $this->addSql('ALTER TABLE ticket CHANGE country country VARCHAR(6) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
