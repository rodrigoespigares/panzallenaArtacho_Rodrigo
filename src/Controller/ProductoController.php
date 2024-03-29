<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/producto')]
class ProductoController extends AbstractController
{
    #[Route('/', name: 'app_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): Response
    {
        $prod = $productoRepository->extract();
        $permitidos = [];
        for ($i=0; $i < count($prod); $i++) { 
            if($prod[$i]->getStock()>0){
                array_push($permitidos, $prod[$i]);
            }
        }
        return $this->render('producto/index.html.twig', [
            'productos' => $permitidos,
        ]);
    }

    #[Route('/{codProd}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    
}
