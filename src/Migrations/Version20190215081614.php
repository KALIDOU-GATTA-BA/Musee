<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215081614 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE reservation_ticket');
        $this->addSql('ALTER TABLE ticket CHANGE country country SMALLINT NOT NULL, CHANGE brith_date birth_date DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reservation_ticket (reservation_id INT NOT NULL, ticket_id INT NOT NULL, INDEX IDX_F06CAF700047D2 (ticket_id), INDEX IDX_F06CAFBAD26311 (ticket_id), PRIMARY KEY(ticket_id, ticket_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation_ticket ADD CONSTRAINT FK_F06CAFBAD26311 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE ticket CHANGE country country VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE birth_date brith_date DATE NOT NULL');
    }
}
