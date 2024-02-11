<?php

namespace App\Entity;

use App\Repository\PedidosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidosRepository::class)]
class Pedidos
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $codPed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?bool $enviado = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'restaurante_id', referencedColumnName: 'cod_res', nullable: false)]
    private ?Restaurante $restaurante = null;

    public function getCodPed(): ?int
    {
        return $this->codPed;
    }

    public function setCodPed(int $codPed): static
    {
        $this->codPed = $codPed;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function isEnviado(): ?bool
    {
        return $this->enviado;
    }

    public function setEnviado(bool $enviado): static
    {
        $this->enviado = $enviado;

        return $this;
    }

    public function getRestaurante(): ?Restaurante
    {
        return $this->restaurante;
    }

    public function setRestaurante(?Restaurante $restaurante): static
    {
        $this->restaurante = $restaurante;

        return $this;
    }
}
