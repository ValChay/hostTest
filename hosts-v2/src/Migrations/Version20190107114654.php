<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190107114654 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE host_table (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress LONGTEXT NOT NULL, address2 LONGTEXT DEFAULT NULL, town VARCHAR(255) NOT NULL, zip_code INT NOT NULL, description LONGTEXT DEFAULT NULL, menu LONGTEXT DEFAULT NULL, price_range INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `table`');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, address LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, address2 LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, town VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, zip_code INT NOT NULL, description LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, menu LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, price_range INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE host_table');
    }
}
