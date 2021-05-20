<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506142438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ejercicio (id INT AUTO_INCREMENT NOT NULL, tipo_ejercicio_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, ejecucion LONGTEXT DEFAULT NULL, foto VARCHAR(255) DEFAULT NULL, INDEX IDX_95ADCFF483DA547D (tipo_ejercicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_ejercicio (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ejercicio ADD CONSTRAINT FK_95ADCFF483DA547D FOREIGN KEY (tipo_ejercicio_id) REFERENCES tipo_ejercicio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ejercicio DROP FOREIGN KEY FK_95ADCFF483DA547D');
        $this->addSql('DROP TABLE ejercicio');
        $this->addSql('DROP TABLE tipo_ejercicio');
    }
}
