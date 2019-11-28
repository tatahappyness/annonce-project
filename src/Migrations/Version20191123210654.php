<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191123210654 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, image_fond VARCHAR(255) NOT NULL, color_fond VARCHAR(255) NOT NULL, comments VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_color (id INT AUTO_INCREMENT NOT NULL, color VARCHAR(255) NOT NULL, comments VARCHAR(255) NOT NULL, ThemeId_id INT DEFAULT NULL, INDEX IDX_3E74C30CE63A36A5 (ThemeId_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_image (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, comments VARCHAR(255) NOT NULL, ThemeId_id INT DEFAULT NULL, INDEX IDX_9D1F8FBAE63A36A5 (ThemeId_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE theme_color ADD CONSTRAINT FK_3E74C30CE63A36A5 FOREIGN KEY (ThemeId_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_image ADD CONSTRAINT FK_9D1F8FBAE63A36A5 FOREIGN KEY (ThemeId_id) REFERENCES theme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE theme_color DROP FOREIGN KEY FK_3E74C30CE63A36A5');
        $this->addSql('ALTER TABLE theme_image DROP FOREIGN KEY FK_9D1F8FBAE63A36A5');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_color');
        $this->addSql('DROP TABLE theme_image');
    }
}
