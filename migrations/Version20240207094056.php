<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207094056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos ADD restaurante_id INT NOT NULL');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAA38B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('CREATE INDEX IDX_6716CCAA38B81E49 ON pedidos (restaurante_id)');
        $this->addSql('ALTER TABLE pedidos_producto ADD producto_id INT NOT NULL, ADD pedido_id INT NOT NULL');
        $this->addSql('ALTER TABLE pedidos_producto ADD CONSTRAINT FK_C4078F697645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE pedidos_producto ADD CONSTRAINT FK_C4078F694854653A FOREIGN KEY (pedido_id) REFERENCES pedidos (id)');
        $this->addSql('CREATE INDEX IDX_C4078F697645698E ON pedidos_producto (producto_id)');
        $this->addSql('CREATE INDEX IDX_C4078F694854653A ON pedidos_producto (pedido_id)');
        $this->addSql('ALTER TABLE producto ADD categoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06153397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('CREATE INDEX IDX_A7BB06153397707A ON producto (categoria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAA38B81E49');
        $this->addSql('DROP INDEX IDX_6716CCAA38B81E49 ON pedidos');
        $this->addSql('ALTER TABLE pedidos DROP restaurante_id');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06153397707A');
        $this->addSql('DROP INDEX IDX_A7BB06153397707A ON producto');
        $this->addSql('ALTER TABLE producto DROP categoria_id');
        $this->addSql('ALTER TABLE pedidos_producto DROP FOREIGN KEY FK_C4078F697645698E');
        $this->addSql('ALTER TABLE pedidos_producto DROP FOREIGN KEY FK_C4078F694854653A');
        $this->addSql('DROP INDEX IDX_C4078F697645698E ON pedidos_producto');
        $this->addSql('DROP INDEX IDX_C4078F694854653A ON pedidos_producto');
        $this->addSql('ALTER TABLE pedidos_producto DROP producto_id, DROP pedido_id');
    }
}
