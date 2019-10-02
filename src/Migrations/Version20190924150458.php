<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190924150458 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offer ADD category_id_id INT DEFAULT NULL, DROP offer_type, DROP unity_price');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_29D6873E9777D11E ON offer (category_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E9777D11E');
        $this->addSql('DROP INDEX IDX_29D6873E9777D11E ON offer');
        $this->addSql('ALTER TABLE offer ADD offer_type VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD unity_price VARCHAR(10) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP category_id_id');
    }
}
