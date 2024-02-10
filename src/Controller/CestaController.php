<?php

namespace App\Controller;

use App\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cesta')]
class CestaController extends AbstractController
{
    #[Route('/', name: 'app_cesta')]
    public function index(): Response
    {
        session_start();
        $resultado="";
        if (isset($_SESSION['carrito'])){
            $resultado=$_SESSION['carrito'];
        }
        return $this->render('cesta/index.html.twig', [
            'cesta' => $resultado
        ]);
    }
    #[Route('/new/{codProd}', name: 'app_cesta_new', methods: ['GET'])]
    public function new(Producto $producto): Response
    {
        session_start();

        if (isset($_SESSION['carrito'])){

            $existe=false;
            for ($i=0;$i<count($_SESSION['carrito']);$i++){
                $carrito=$_SESSION['carrito'][$i];

                if ($carrito['id']==($producto->getCodProd())){
                    if ($carrito['cantidad']<$producto->getStock()){
                        $carrito['cantidad']++;
                    }
                    $existe=true;
                }
                $_SESSION['carrito'][$i]=$carrito;
            }
            if (!$existe){
                array_push($_SESSION['carrito'],["id"=>($producto->getCodProd()),"cantidad"=>1,"producto"=>$producto]);
            }
        }else{
            $_SESSION['carrito']=[["id"=>($producto->getCodProd()),"cantidad"=>1,"producto"=>$producto]];
        }

        return $this->render('cesta/index.html.twig', [
            'cesta' => $_SESSION['carrito'],
        ]);
    }
    #[Route('/restar/{codProd}', name: 'app_cesta_menos', methods: ['GET'])]
    public function menos(Producto $producto): Response
    {
        session_start();
        if (isset($_SESSION['carrito'])){
            for ($i=0;$i<count($_SESSION['carrito']);$i++){
                $carrito=$_SESSION['carrito'][$i];
                if ($carrito['id']==($producto->getCodProd())){
                    if ($carrito['cantidad']==1){
                        unset($_SESSION['carrito'][$i]);
                    }else{
                        $carrito['cantidad']--;
                        $_SESSION['carrito'][$i]=$carrito;
                    }
                }
            }
        }
        return $this->render('cesta/index.html.twig', [
            'cesta' => $_SESSION['carrito'],
        ]);
    }
    #[Route('/delete/{codProd}', name: 'app_cesta_delete', methods: ['GET'])]
    public function delete(Producto $producto): Response
    {
        session_start();
        if (isset($_SESSION['carrito'])){
            for ($i=0;$i<count($_SESSION['carrito']);$i++){
                $carrito=$_SESSION['carrito'][$i];
                if ($carrito['id']==($producto->getCodProd())){
                    unset($_SESSION['carrito'][$i]);
                }
            }
        }
        return $this->render('cesta/index.html.twig', [
            'cesta' => $_SESSION['carrito'],
        ]);
    }
}
