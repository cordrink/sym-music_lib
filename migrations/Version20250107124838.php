<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107124838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43B7970CF8');
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B231137ABCF');
        $this->addSql('ALTER TABLE style_album DROP FOREIGN KEY FK_F34D20B8BACD6074');
        $this->addSql('ALTER TABLE style_album DROP FOREIGN KEY FK_F34D20B81137ABCF');

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE artiste CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE piece CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE style CHANGE id id INT AUTO_INCREMENT NOT NULL');

        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artiste (id)');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B231137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B8BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B81137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE artiste CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE piece CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE style CHANGE id id INT NOT NULL');
    }
}
