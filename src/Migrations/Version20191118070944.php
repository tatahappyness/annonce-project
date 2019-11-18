<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191118070944 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE catalogue_site (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD article_sous_categ_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F412BBDE FOREIGN KEY (article_sous_categ_id_id) REFERENCES sous_category (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_23A0E66F412BBDE ON article (article_sous_categ_id_id)');
        $this->addSql('ALTER TABLE comments ADD is_publish TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE configsite ADD is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD appartement_type VARCHAR(250) DEFAULT NULL, DROP devis_is_accepted, DROP devis_is_validated, DROP devis_is_finished');
        $this->addSql('ALTER TABLE guide_price DROP FOREIGN KEY FK_8ED5E9919777D11E');
        $this->addSql('DROP INDEX IDX_8ED5E9919777D11E ON guide_price');
        $this->addSql('ALTER TABLE guide_price CHANGE category_id_id sous_category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guide_price ADD CONSTRAINT FK_8ED5E991EA4D28AA FOREIGN KEY (sous_category_id_id) REFERENCES sous_category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8ED5E991EA4D28AA ON guide_price (sous_category_id_id)');
        $this->addSql('ALTER TABLE mode_prix DROP FOREIGN KEY FK_9C65B0D4C81E761');
        $this->addSql('DROP INDEX IDX_9C65B0D4C81E761 ON mode_prix');
        $this->addSql('ALTER TABLE mode_prix CHANGE prix_description prix_description TINYTEXT DEFAULT NULL, CHANGE prix_category_id_id prix_sous_category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mode_prix ADD CONSTRAINT FK_9C65B0D970AEB7F FOREIGN KEY (prix_sous_category_id_id) REFERENCES sous_category (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_9C65B0D970AEB7F ON mode_prix (prix_sous_category_id_id)');
        $this->addSql('ALTER TABLE siteinternet ADD firstname VARCHAR(255) DEFAULT NULL, ADD name VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD date_crea DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE sous_category ADD sous_categ_intro LONGTEXT DEFAULT NULL, ADD sous_categ_link_question VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE company_date_crea company_date_crea VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE catalogue_site');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F412BBDE');
        $this->addSql('DROP INDEX IDX_23A0E66F412BBDE ON article');
        $this->addSql('ALTER TABLE article DROP article_sous_categ_id_id');
        $this->addSql('ALTER TABLE comments DROP is_publish');
        $this->addSql('ALTER TABLE configsite DROP is_active');
        $this->addSql('ALTER TABLE devis ADD devis_is_accepted TINYINT(1) DEFAULT NULL, ADD devis_is_validated TINYINT(1) DEFAULT NULL, ADD devis_is_finished TINYINT(1) DEFAULT NULL, DROP appartement_type');
        $this->addSql('ALTER TABLE guide_price DROP FOREIGN KEY FK_8ED5E991EA4D28AA');
        $this->addSql('DROP INDEX IDX_8ED5E991EA4D28AA ON guide_price');
        $this->addSql('ALTER TABLE guide_price CHANGE sous_category_id_id category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guide_price ADD CONSTRAINT FK_8ED5E9919777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8ED5E9919777D11E ON guide_price (category_id_id)');
        $this->addSql('ALTER TABLE mode_prix DROP FOREIGN KEY FK_9C65B0D970AEB7F');
        $this->addSql('DROP INDEX IDX_9C65B0D970AEB7F ON mode_prix');
        $this->addSql('ALTER TABLE mode_prix CHANGE prix_description prix_description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE prix_sous_category_id_id prix_category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mode_prix ADD CONSTRAINT FK_9C65B0D4C81E761 FOREIGN KEY (prix_category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_9C65B0D4C81E761 ON mode_prix (prix_category_id_id)');
        $this->addSql('ALTER TABLE siteinternet DROP firstname, DROP name, DROP email, DROP phone, DROP date_crea');
        $this->addSql('ALTER TABLE sous_category DROP sous_categ_intro, DROP sous_categ_link_question');
        $this->addSql('ALTER TABLE user CHANGE company_date_crea company_date_crea DATE DEFAULT NULL');
    }
}
