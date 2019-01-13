<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110090117 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, host_id INT NOT NULL, date DATETIME NOT NULL, price INT NOT NULL, capacity INT NOT NULL, remaining_capacity INT NOT NULL, INDEX IDX_9EF68E9C1FB8D185 (host_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_user (meal_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_974D05BD639666D6 (meal_id), INDEX IDX_974D05BDA76ED395 (user_id), PRIMARY KEY(meal_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C1FB8D185 FOREIGN KEY (host_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meal_user ADD CONSTRAINT FK_974D05BD639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_user ADD CONSTRAINT FK_974D05BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meal_user DROP FOREIGN KEY FK_974D05BD639666D6');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE meal_user');
    }
}
