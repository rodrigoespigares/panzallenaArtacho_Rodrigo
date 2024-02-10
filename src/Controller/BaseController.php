<?php

namespace App\Controller;

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
}
