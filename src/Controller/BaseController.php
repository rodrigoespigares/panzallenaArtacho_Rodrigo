<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Producto;
use App\Entity\Pedidos;

use App\Repository\CategoriaRepository;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'app_base')]
    public function index(CategoriaRepository $categoriaRepository, ProductoRepository $productoRepository): Response
    {
        $cat = $categoriaRepository->extract();
        $prod = $productoRepository->extract();
        return $this->render('base/index.html.twig', [
            'categorias' => $cat,'productos' => $prod
        ]);
    }
    #[Route('/detalle/producto/{codProd}', name: 'app_producto_detalle', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }
}
