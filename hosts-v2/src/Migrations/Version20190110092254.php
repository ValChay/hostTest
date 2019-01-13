<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110092254 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BD16D44A');
        $this->addSql('DROP INDEX IDX_42C84955BD16D44A ON reservation');
        $this->addSql('ALTER TABLE reservation ADD meal_id INT DEFAULT NULL, DROP host_table_id');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
        $this->addSql('CREATE INDEX IDX_42C84955639666D6 ON reservation (meal_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955639666D6');
        $this->addSql('DROP INDEX IDX_42C84955639666D6 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD host_table_id INT NOT NULL, DROP meal_id');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BD16D44A FOREIGN KEY (host_table_id) REFERENCES host_table (id)');
        $this->addSql('CREATE INDEX IDX_42C84955BD16D44A ON reservation (host_table_id)');
    }
}
