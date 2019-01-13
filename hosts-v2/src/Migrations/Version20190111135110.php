<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190111135110 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE host_table DROP FOREIGN KEY FK_554BC2B567B3B43D');
        $this->addSql('DROP INDEX IDX_554BC2B567B3B43D ON host_table');
        $this->addSql('ALTER TABLE host_table ADD user_id INT NOT NULL, DROP users_id');
        $this->addSql('ALTER TABLE host_table ADD CONSTRAINT FK_554BC2B5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_554BC2B5A76ED395 ON host_table (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE host_table DROP FOREIGN KEY FK_554BC2B5A76ED395');
        $this->addSql('DROP INDEX IDX_554BC2B5A76ED395 ON host_table');
        $this->addSql('ALTER TABLE host_table ADD users_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE host_table ADD CONSTRAINT FK_554BC2B567B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_554BC2B567B3B43D ON host_table (users_id)');
    }
}
