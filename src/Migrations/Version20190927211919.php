<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190927211919 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category ADD img VARCHAR(255) DEFAULT NULL, ADD icon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B9777D11E ON devis (category_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP img, DROP icon');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B9777D11E');
        $this->addSql('DROP INDEX IDX_8B27C52B9777D11E ON devis');
        $this->addSql('ALTER TABLE devis DROP category_id_id');
    }
}
