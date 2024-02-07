<?php

namespace App\Entity;

use App\Repository\PedidosProductoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidosProductoRepository::class)]
class PedidosProducto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $codPedProd = null;

    #[ORM\Column]
    private ?int $unidades = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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
}
