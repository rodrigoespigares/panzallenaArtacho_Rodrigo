<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $codCat = null;

    #[ORM\Column(length: 45)]
    private ?string $nombre = null;

    #[ORM\Column(length: 200)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private bool $descatalogado = false;


    public function getCodCat(): ?int
    {
        return $this->codCat;
    }

    public function setCodCat(int $codCat): static
    {
        $this->codCat = $codCat;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }
    public function __toString(){
        return (string) $this->codCat;
    }

    public function isDescatalogado(): ?bool
    {
        return $this->descatalogado;
    }

    public function setDescatalogado(bool $descatalogado): static
    {
        $this->descatalogado = $descatalogado;

        return $this;
    }
}
