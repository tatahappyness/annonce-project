<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191208133635 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX post_zipcode ON post');
        $this->addSql('ALTER TABLE post ADD num_departement INT DEFAULT NULL, CHANGE city_id city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD num_departement VARCHAR(150) DEFAULT NULL, ADD is_verified TINYINT(1) DEFAULT NULL, ADD token VARCHAR(255) DEFAULT NULL, ADD kilometer INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B8BAC62AF');
        $this->addSql('DROP INDEX IDX_8B27C52B8BAC62AF ON devis');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8BAC62AF');
        $this->addSql('DROP INDEX IDX_5A8A6C8D8BAC62AF ON post');
        $this->addSql('CREATE INDEX post_zipcode ON post (post_zipcode)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D3A17CA5');
        $this->addSql('DROP INDEX IDX_8D93D649D3A17CA5 ON user');
    }
}
