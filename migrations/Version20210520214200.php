<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520214200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ejercicio (id INT AUTO_INCREMENT NOT NULL, tipo_ejercicio_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, ejecucion LONGTEXT DEFAULT NULL, foto VARCHAR(255) DEFAULT NULL, INDEX IDX_95ADCFF483DA547D (tipo_ejercicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ejercicios_rutina (id INT AUTO_INCREMENT NOT NULL, rutina_id INT NOT NULL, ejercicio_id INT NOT NULL, tiempo DOUBLE PRECISION DEFAULT NULL, series INT DEFAULT NULL, repeticiones INT DEFAULT NULL, INDEX IDX_7A389C30D7A88FCB (rutina_id), INDEX IDX_7A389C3030890A7D (ejercicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, redes_sociales_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, fecha_nac DATE NOT NULL, foto VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D9D9BF52E7927C74 (email), UNIQUE INDEX UNIQ_D9D9BF52BD5BE588 (redes_sociales_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estadistica (id INT AUTO_INCREMENT NOT NULL, socio_id INT DEFAULT NULL, peso DOUBLE PRECISION DEFAULT NULL, altura DOUBLE PRECISION DEFAULT NULL, imc DOUBLE PRECISION DEFAULT NULL, INDEX IDX_DF3A8544DA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE red_social (id INT AUTO_INCREMENT NOT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rutina (id INT AUTO_INCREMENT NOT NULL, socio_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_creacion DATE NOT NULL, INDEX IDX_A48AB255DA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE socio (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, fecha_nacimiento DATE NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_ejercicio (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ejercicio ADD CONSTRAINT FK_95ADCFF483DA547D FOREIGN KEY (tipo_ejercicio_id) REFERENCES tipo_ejercicio (id)');
        $this->addSql('ALTER TABLE ejercicios_rutina ADD CONSTRAINT FK_7A389C30D7A88FCB FOREIGN KEY (rutina_id) REFERENCES rutina (id)');
        $this->addSql('ALTER TABLE ejercicios_rutina ADD CONSTRAINT FK_7A389C3030890A7D FOREIGN KEY (ejercicio_id) REFERENCES ejercicio (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52BD5BE588 FOREIGN KEY (redes_sociales_id) REFERENCES red_social (id)');
        $this->addSql('ALTER TABLE estadistica ADD CONSTRAINT FK_DF3A8544DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE rutina ADD CONSTRAINT FK_A48AB255DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ejercicios_rutina DROP FOREIGN KEY FK_7A389C3030890A7D');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52BD5BE588');
        $this->addSql('ALTER TABLE ejercicios_rutina DROP FOREIGN KEY FK_7A389C30D7A88FCB');
        $this->addSql('ALTER TABLE estadistica DROP FOREIGN KEY FK_DF3A8544DA04E6A9');
        $this->addSql('ALTER TABLE rutina DROP FOREIGN KEY FK_A48AB255DA04E6A9');
        $this->addSql('ALTER TABLE ejercicio DROP FOREIGN KEY FK_95ADCFF483DA547D');
        $this->addSql('DROP TABLE ejercicio');
        $this->addSql('DROP TABLE ejercicios_rutina');
        $this->addSql('DROP TABLE empleado');
        $this->addSql('DROP TABLE estadistica');
        $this->addSql('DROP TABLE red_social');
        $this->addSql('DROP TABLE rutina');
        $this->addSql('DROP TABLE socio');
        $this->addSql('DROP TABLE tipo_ejercicio');
    }
}
