<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110093956 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C1FB8D185');
        $this->addSql('DROP INDEX IDX_9EF68E9C1FB8D185 ON meal');
        $this->addSql('ALTER TABLE meal ADD host_table_id INT DEFAULT NULL, DROP host_id');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9CBD16D44A FOREIGN KEY (host_table_id) REFERENCES host_table (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9CBD16D44A ON meal (host_table_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9CBD16D44A');
        $this->addSql('DROP INDEX IDX_9EF68E9CBD16D44A ON meal');
        $this->addSql('ALTER TABLE meal ADD host_id INT NOT NULL, DROP host_table_id');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C1FB8D185 FOREIGN KEY (host_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C1FB8D185 ON meal (host_id)');
    }
}
