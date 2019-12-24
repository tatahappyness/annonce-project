<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191215212204 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE devis ADD fonction_category VARCHAR(200) DEFAULT NULL, ADD timer_appontement VARCHAR(100) DEFAULT NULL');
       
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX zip_code ON devis (zip_code)');
        $this->addSql('CREATE INDEX num_departement ON devis (num_departement)');
        $this->addSql('CREATE INDEX post_zipcode ON post (post_zipcode)');
        $this->addSql('CREATE INDEX num_departement ON post (num_departement)');
        $this->addSql('CREATE INDEX zip_code ON user (zip_code)');
        $this->addSql('CREATE INDEX token ON user (token)');
    }
}
