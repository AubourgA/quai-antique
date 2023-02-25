<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225111107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, price NUMERIC(5, 2) NOT NULL, url_image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_dessert (menu_id INT NOT NULL, dessert_id INT NOT NULL, INDEX IDX_F1F20628CCD7E912 (menu_id), INDEX IDX_F1F20628745B52FD (dessert_id), PRIMARY KEY(menu_id, dessert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_meals (menu_id INT NOT NULL, meals_id INT NOT NULL, INDEX IDX_7385C58DCCD7E912 (menu_id), INDEX IDX_7385C58D88A25CA2 (meals_id), PRIMARY KEY(menu_id, meals_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_entree (menu_id INT NOT NULL, entree_id INT NOT NULL, INDEX IDX_8AC42F7ECCD7E912 (menu_id), INDEX IDX_8AC42F7EAF7BD910 (entree_id), PRIMARY KEY(menu_id, entree_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_dessert ADD CONSTRAINT FK_F1F20628CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_dessert ADD CONSTRAINT FK_F1F20628745B52FD FOREIGN KEY (dessert_id) REFERENCES dessert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_meals ADD CONSTRAINT FK_7385C58DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_meals ADD CONSTRAINT FK_7385C58D88A25CA2 FOREIGN KEY (meals_id) REFERENCES meals (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_entree ADD CONSTRAINT FK_8AC42F7ECCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_entree ADD CONSTRAINT FK_8AC42F7EAF7BD910 FOREIGN KEY (entree_id) REFERENCES entree (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_dessert DROP FOREIGN KEY FK_F1F20628CCD7E912');
        $this->addSql('ALTER TABLE menu_dessert DROP FOREIGN KEY FK_F1F20628745B52FD');
        $this->addSql('ALTER TABLE menu_meals DROP FOREIGN KEY FK_7385C58DCCD7E912');
        $this->addSql('ALTER TABLE menu_meals DROP FOREIGN KEY FK_7385C58D88A25CA2');
        $this->addSql('ALTER TABLE menu_entree DROP FOREIGN KEY FK_8AC42F7ECCD7E912');
        $this->addSql('ALTER TABLE menu_entree DROP FOREIGN KEY FK_8AC42F7EAF7BD910');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_dessert');
        $this->addSql('DROP TABLE menu_meals');
        $this->addSql('DROP TABLE menu_entree');
    }
}
