<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212130239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (cod_cat INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(200) NOT NULL, PRIMARY KEY(cod_cat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedidos (cod_ped INT AUTO_INCREMENT NOT NULL, restaurante_id INT NOT NULL, fecha DATE NOT NULL, enviado TINYINT(1) NOT NULL, INDEX IDX_6716CCAA38B81E49 (restaurante_id), PRIMARY KEY(cod_ped)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedidos_producto (cod_ped_prod INT AUTO_INCREMENT NOT NULL, producto_id INT NOT NULL, pedido_id INT NOT NULL, unidades INT NOT NULL, INDEX IDX_C4078F697645698E (producto_id), INDEX IDX_C4078F694854653A (pedido_id), PRIMARY KEY(cod_ped_prod)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (cod_prod INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(90) NOT NULL, peso DOUBLE PRECISION NOT NULL, stock INT NOT NULL, foto VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, INDEX IDX_A7BB06153397707A (categoria_id), PRIMARY KEY(cod_prod)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurante (cod_res INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_5957C275E7927C74 (email), PRIMARY KEY(cod_res)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAA38B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (cod_res)');
        $this->addSql('ALTER TABLE pedidos_producto ADD CONSTRAINT FK_C4078F697645698E FOREIGN KEY (producto_id) REFERENCES producto (cod_prod)');
        $this->addSql('ALTER TABLE pedidos_producto ADD CONSTRAINT FK_C4078F694854653A FOREIGN KEY (pedido_id) REFERENCES pedidos (cod_ped)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06153397707A FOREIGN KEY (categoria_id) REFERENCES categoria (cod_cat)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAA38B81E49');
        $this->addSql('ALTER TABLE pedidos_producto DROP FOREIGN KEY FK_C4078F697645698E');
        $this->addSql('ALTER TABLE pedidos_producto DROP FOREIGN KEY FK_C4078F694854653A');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06153397707A');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE pedidos');
        $this->addSql('DROP TABLE pedidos_producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE restaurante');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
