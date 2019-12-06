<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191205122711 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX zip_code ON devis');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B8BAC62AF ON devis (city_id)');
        $this->addSql('DROP INDEX post_zipcode ON post');
        $this->addSql('ALTER TABLE post ADD city_id INT DEFAULT NULL, DROP city');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D8BAC62AF ON post (city_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D3A17CA5 FOREIGN KEY (user_city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D3A17CA5 ON user (user_city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B8BAC62AF');
        $this->addSql('DROP INDEX IDX_8B27C52B8BAC62AF ON devis');
        $this->addSql('CREATE INDEX zip_code ON devis (zip_code)');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8BAC62AF');
        $this->addSql('DROP INDEX IDX_5A8A6C8D8BAC62AF ON post');
        $this->addSql('ALTER TABLE post ADD city VARCHAR(200) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP city_id');
        $this->addSql('CREATE INDEX post_zipcode ON post (post_zipcode)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D3A17CA5');
        $this->addSql('DROP INDEX IDX_8D93D649D3A17CA5 ON user');
    }
}
