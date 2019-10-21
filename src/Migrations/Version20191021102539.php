<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021102539 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE chantier_of_month (id INT AUTO_INCREMENT NOT NULL, category_id_id INT DEFAULT NULL, article_id_id INT DEFAULT NULL, description VARCHAR(250) DEFAULT NULL, image_befor VARCHAR(250) DEFAULT NULL, image_after VARCHAR(250) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_FAC29C5F9777D11E (category_id_id), INDEX IDX_FAC29C5F8F3EC46 (article_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guide_price (id INT AUTO_INCREMENT NOT NULL, category_id_id INT DEFAULT NULL, article_id_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, date_crea DATETIME DEFAULT NULL, subject_link VARCHAR(250) DEFAULT NULL, image VARCHAR(250) DEFAULT NULL, INDEX IDX_8ED5E9919777D11E (category_id_id), INDEX IDX_8ED5E9918F3EC46 (article_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chantier_of_month ADD CONSTRAINT FK_FAC29C5F9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE chantier_of_month ADD CONSTRAINT FK_FAC29C5F8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE guide_price ADD CONSTRAINT FK_8ED5E9919777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE guide_price ADD CONSTRAINT FK_8ED5E9918F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE user ADD date_crea DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE chantier_of_month');
        $this->addSql('DROP TABLE guide_price');
        $this->addSql('ALTER TABLE user DROP date_crea');
    }
}
