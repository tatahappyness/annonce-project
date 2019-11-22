<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120152503 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE abonnenent');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1699777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sous_category ADD CONSTRAINT FK_E022D94C38715A8 FOREIGN KEY (cat_sous_category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649887AF182 FOREIGN KEY (user_category_activity_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D3A17CA5 FOREIGN KEY (user_city_id) REFERENCES cities (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA64325F7773D6 FOREIGN KEY (article_title_id) REFERENCES article (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA64329D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE abonnenent (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1699777D11E');
        $this->addSql('ALTER TABLE sous_category DROP FOREIGN KEY FK_E022D94C38715A8');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B171EB6C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649887AF182');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D3A17CA5');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA64325F7773D6');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA64329D86650F');
    }
}
