<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920094532 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post ADD post_city_id INT DEFAULT NULL, DROP post_city');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB644D59C FOREIGN KEY (post_city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DB644D59C ON post (post_city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB644D59C');
        $this->addSql('DROP INDEX IDX_5A8A6C8DB644D59C ON post');
        $this->addSql('ALTER TABLE post ADD post_city VARCHAR(200) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP post_city_id');
    }
}
