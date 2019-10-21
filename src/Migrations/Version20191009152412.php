<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009152412 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evaluations ADD user_part_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluations ADD CONSTRAINT FK_3B72691D4B500F58 FOREIGN KEY (user_part_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3B72691D4B500F58 ON evaluations (user_part_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evaluations DROP FOREIGN KEY FK_3B72691D4B500F58');
        $this->addSql('DROP INDEX IDX_3B72691D4B500F58 ON evaluations');
        $this->addSql('ALTER TABLE evaluations DROP user_part_id_id');
    }
}
