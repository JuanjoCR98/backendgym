<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602191039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE empleado ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D9D9BF52DB38439E ON empleado (usuario_id)');
        $this->addSql('ALTER TABLE socio ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B65309DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38B65309DB38439E ON socio (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52DB38439E');
        $this->addSql('ALTER TABLE socio DROP FOREIGN KEY FK_38B65309DB38439E');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP INDEX UNIQ_D9D9BF52DB38439E ON empleado');
        $this->addSql('ALTER TABLE empleado DROP usuario_id');
        $this->addSql('DROP INDEX UNIQ_38B65309DB38439E ON socio');
        $this->addSql('ALTER TABLE socio DROP usuario_id');
    }
}
