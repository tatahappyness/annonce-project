<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191125035646 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE theme_image DROP FOREIGN KEY FK_9D1F8FBAE63A36A5');
        $this->addSql('DROP INDEX IDX_9D1F8FBAE63A36A5 ON theme_image');
        $this->addSql('ALTER TABLE theme_image CHANGE themeid_id theme_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE theme_image ADD CONSTRAINT FK_9D1F8FBA276615B2 FOREIGN KEY (theme_id_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9D1F8FBA276615B2 ON theme_image (theme_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE theme_image DROP FOREIGN KEY FK_9D1F8FBA276615B2');
        $this->addSql('DROP INDEX IDX_9D1F8FBA276615B2 ON theme_image');
        $this->addSql('ALTER TABLE theme_image CHANGE theme_id_id ThemeId_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE theme_image ADD CONSTRAINT FK_9D1F8FBAE63A36A5 FOREIGN KEY (ThemeId_id) REFERENCES theme (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9D1F8FBAE63A36A5 ON theme_image (ThemeId_id)');
    }
}
