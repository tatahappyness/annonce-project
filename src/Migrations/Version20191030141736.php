<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030141736 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE categ_date_crea categ_date_crea DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE article CHANGE article_date_crea article_date_crea DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE mode_prix CHANGE prix_date_crea prix_date_crea DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE article_date_crea article_date_crea DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE categ_date_crea categ_date_crea DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE mode_prix CHANGE prix_date_crea prix_date_crea DATE DEFAULT NULL');
    }
}
