<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307124836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capacity (id INT AUTO_INCREMENT NOT NULL, supervisor_id INT NOT NULL, lunch_limit INT NOT NULL, dinner_limit INT NOT NULL, INDEX IDX_B5E8B17419E9AC5F (supervisor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capacity ADD CONSTRAINT FK_B5E8B17419E9AC5F FOREIGN KEY (supervisor_id) REFERENCES `admin` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capacity DROP FOREIGN KEY FK_B5E8B17419E9AC5F');
        $this->addSql('DROP TABLE capacity');
    }
}
