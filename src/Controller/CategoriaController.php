<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**Controlador para gestionar las categorias y accesible por parte de los usuarios */
#[Route('/categoria')]
class CategoriaController extends AbstractController
{
    // Ver el detalle de una categoria junto a todos sus productos
    #[Route('/{codCat}', name: 'app_categoria_show_user', methods: ['GET'])]
    public function show(Categoria $categorium, ProductoRepository $productoRepository): Response
    {
        $prod = $productoRepository->extract();
        $permitidos = [];
        for ($i=0; $i < count($prod); $i++) { 
            if($prod[$i]->getStock()>0){
                array_push($permitidos, $prod[$i]);
            }
        }
        return $this->render('categoria/show.html.twig', [
            'categorium' => $categorium,
            'productos' => $permitidos
        ]);
    }

}
