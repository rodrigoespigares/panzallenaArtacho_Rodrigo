<?php

namespace App\Entity;

use App\Repository\PedidosProductoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidosProductoRepository::class)]
class PedidosProducto
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $codPedProd = null;

    #[ORM\Column]
    private ?int $unidades = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'producto_id', referencedColumnName: 'cod_prod', nullable: false)]
    private ?Producto $producto = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'pedido_id', referencedColumnName: 'cod_ped', nullable: false)]
    private ?Pedidos $pedido = null;

    public function getCodPedProd(): ?int
    {
        return $this->codPedProd;
    }

    public function setCodPedProd(int $codPedProd): static
    {
        $this->codPedProd = $codPedProd;

        return $this;
    }

    public function getUnidades(): ?int
    {
        return $this->unidades;
    }

    public function setUnidades(int $unidades): static
    {
        $this->unidades = $unidades;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

        return $this;
    }

    public function getPedido(): ?Pedidos
    {
        return $this->pedido;
    }

    public function setPedido(?Pedidos $pedido): static
    {
        $this->pedido = $pedido;

        return $this;
    }
}
