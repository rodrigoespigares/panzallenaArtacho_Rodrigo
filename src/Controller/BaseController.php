<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'app_base')]
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('base/index.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }
}
