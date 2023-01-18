<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118190358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conta (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, agencia_id INT DEFAULT NULL, tipo_id INT DEFAULT NULL, numero INT NOT NULL, saldo DOUBLE PRECISION NOT NULL, situacao VARCHAR(255) DEFAULT NULL, INDEX IDX_485A16C3DB38439E (usuario_id), INDEX IDX_485A16C3A6F796BE (agencia_id), INDEX IDX_485A16C3A9276E6C (tipo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gerente (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_306C486DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operacao (id INT AUTO_INCREMENT NOT NULL, destino_id INT DEFAULT NULL, envio_id INT DEFAULT NULL, descricao VARCHAR(255) NOT NULL, valor DOUBLE PRECISION NOT NULL, data DATETIME NOT NULL, INDEX IDX_334A5323E4360615 (destino_id), INDEX IDX_334A532395BC4699 (envio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_conta (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conta ADD CONSTRAINT FK_485A16C3DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conta ADD CONSTRAINT FK_485A16C3A6F796BE FOREIGN KEY (agencia_id) REFERENCES agencia (id)');
        $this->addSql('ALTER TABLE conta ADD CONSTRAINT FK_485A16C3A9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_conta (id)');
        $this->addSql('ALTER TABLE gerente ADD CONSTRAINT FK_306C486DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operacao ADD CONSTRAINT FK_334A5323E4360615 FOREIGN KEY (destino_id) REFERENCES conta (id)');
        $this->addSql('ALTER TABLE operacao ADD CONSTRAINT FK_334A532395BC4699 FOREIGN KEY (envio_id) REFERENCES conta (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conta DROP FOREIGN KEY FK_485A16C3DB38439E');
        $this->addSql('ALTER TABLE conta DROP FOREIGN KEY FK_485A16C3A6F796BE');
        $this->addSql('ALTER TABLE conta DROP FOREIGN KEY FK_485A16C3A9276E6C');
        $this->addSql('ALTER TABLE gerente DROP FOREIGN KEY FK_306C486DA76ED395');
        $this->addSql('ALTER TABLE operacao DROP FOREIGN KEY FK_334A5323E4360615');
        $this->addSql('ALTER TABLE operacao DROP FOREIGN KEY FK_334A532395BC4699');
        $this->addSql('DROP TABLE conta');
        $this->addSql('DROP TABLE gerente');
        $this->addSql('DROP TABLE operacao');
        $this->addSql('DROP TABLE tipo_conta');
        $this->addSql('DROP TABLE user');
    }
}
