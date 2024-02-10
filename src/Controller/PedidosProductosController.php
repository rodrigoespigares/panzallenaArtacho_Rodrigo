<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PedidosProductosController extends AbstractController
{
    #[Route('/pedidos/productos', name: 'app_pedidos_productos')]
    public function index(): Response
    {
        return $this->render('pedidos_productos/index.html.twig', [
            'controller_name' => 'PedidosProductosController',
        ]);
    }
}
