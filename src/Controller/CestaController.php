<?php

namespace App\Controller;

use App\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

/** Controlador para gestionar la cesta */
#[Route('/cesta')]
class CestaController extends AbstractController
{
    /** Función para ver el detalle de la cesta */
    #[Route('/', name: 'app_cesta')]
    public function index(SessionInterface $session): Response
    {
        $resultado = $session->get('carrito', []);

        return $this->render('cesta/index.html.twig', [
            'cesta' => $resultado
        ]);
    }
    /** Función para crear un nuevo producto pasandole el ID */
    #[Route('/new/{codProd}', name: 'app_cesta_new', methods: ['GET'])]
    public function new(Producto $producto, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);


        $existe = false;
        foreach ($carrito as &$item) {
            if ($item['id'] == $producto->getCodProd()) {
                if ($item['cantidad'] < $producto->getStock()) {
                    $item['cantidad']++;
                }
                $existe = true;
            }
        }

        if (!$existe) {
            $carrito[] = [
                'id' => $producto->getCodProd(),
                'cantidad' => 1,
                'producto' => $producto,
            ];
        }

        $session->set('carrito', $carrito);
        return  $this->redirectToRoute("app_cesta");
    }
    /** Función para restar un producto pasandole el ID */
    #[Route('/restar/{codProd}', name: 'app_cesta_menos', methods: ['GET'])]
    public function menos(Producto $producto, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);

        foreach ($carrito as $key => &$item) {
            if ($item['id'] == $producto->getCodProd()) {
                if ($item['cantidad'] == 1) {
                    unset($carrito[$key]);
                } else {
                    $item['cantidad']--;
                }
            }
        }

        $session->set('carrito', $carrito);

        return  $this->redirectToRoute("app_cesta");
    }
    /** Función para eliminar un producto el carrito por el id */
    #[Route('/delete/{codProd}', name: 'app_cesta_delete', methods: ['GET'])]
    public function delete(Producto $producto, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);
        foreach ($carrito as $key => $item) {
            if ($item['id'] == $producto->getCodProd()) {
                unset($carrito[$key]);
            }
        }

        $session->set('carrito', $carrito);

        return  $this->redirectToRoute("app_cesta");
    }
}
