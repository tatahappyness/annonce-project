<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920210125 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE devis_accept (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, devis_id_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_8F352AF89D86650F (user_id_id), INDEX IDX_8F352AF869678373 (devis_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_finish (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, devis_valid_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_1CDC2CD49D86650F (user_id_id), INDEX IDX_1CDC2CD486C35500 (devis_valid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_valid (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, devis_accept_id_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_9A2428DB9D86650F (user_id_id), INDEX IDX_9A2428DBAA508A34 (devis_accept_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devis_accept ADD CONSTRAINT FK_8F352AF89D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE devis_accept ADD CONSTRAINT FK_8F352AF869678373 FOREIGN KEY (devis_id_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE devis_finish ADD CONSTRAINT FK_1CDC2CD49D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE devis_finish ADD CONSTRAINT FK_1CDC2CD486C35500 FOREIGN KEY (devis_valid_id) REFERENCES devis_valid (id)');
        $this->addSql('ALTER TABLE devis_valid ADD CONSTRAINT FK_9A2428DB9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE devis_valid ADD CONSTRAINT FK_9A2428DBAA508A34 FOREIGN KEY (devis_accept_id_id) REFERENCES devis_accept (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis_valid DROP FOREIGN KEY FK_9A2428DBAA508A34');
        $this->addSql('ALTER TABLE devis_finish DROP FOREIGN KEY FK_1CDC2CD486C35500');
        $this->addSql('DROP TABLE devis_accept');
        $this->addSql('DROP TABLE devis_finish');
        $this->addSql('DROP TABLE devis_valid');
    }
}
