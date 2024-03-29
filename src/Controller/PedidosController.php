<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\Restaurante;
use App\Form\PedidosType;
use App\Repository\PedidosProductoRepository;
use App\Repository\PedidosRepository;
use App\Repository\ProductoRepository;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;

/** Controlador para gestionar los pedidos */
#[Route('/pedidos')]
class PedidosController extends AbstractController
{
    /** Función para ver todos tus pedidos */
    #[Route('/', name: 'app_pedidos_index', methods: ['GET'])]
    public function index(PedidosRepository $pedidosRepository): Response
    {

        $user = $this->getUser();
        if ($user instanceof \App\Entity\Restaurante) {
            $restauranteId = $user->getCod_res(); // Ajusta el método según la implementación en tu clase User
            $pedidos = $pedidosRepository->findBy(['restaurante' => $restauranteId]);
        }

        return $this->render('pedidos/index.html.twig', [
            'pedidos' => $pedidos,
        ]);
    }
    /**  Función para crear un nuevo pedido */
    #[Route('/new', name: 'app_pedidos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $sesion, PedidosRepository $pedidosRepository,RestauranteRepository $restauranteRepository, MailerController $mail, MailerInterface $mailerInterface, ProductoRepository $productoRepository): Response
    {
        if(count($sesion->get("carrito"))>0){
            $pedido = new Pedidos();
            $form = $this->createForm(PedidosType::class, $pedido);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $user = $this->getUser();
                if ($user instanceof \App\Entity\Restaurante) {
                    $data['time'] = time();
                    $dateTime = new DateTime();
                    $dateTime->setTimestamp($data['time']);
                    $data['fecha'] = $dateTime->format('Y-m-d H:i:s');
                    $data['enviado'] = false;
                    $data['restaurante_id'] = $user->getCod_res();
                }
                $n_ped = $pedidosRepository->anadir($data,$sesion->get("carrito"),$restauranteRepository, $entityManager, $productoRepository);

                $mail->sendEmail($mailerInterface,$sesion->get('carrito'), $n_ped);
                $mail->sendEmailPedidos($mailerInterface,$sesion->get('carrito'),$n_ped);
                $sesion->set("carrito",[]);
                return $this->redirectToRoute('app_base', [], Response::HTTP_SEE_OTHER);
            }
            $carrito = $sesion->get('carrito');

            return $this->render('pedidos/new.html.twig', [
                'pedido' => $pedido,
                'form' => $form,
                'cesta' => $carrito,
                
            ]);
        }else{
            return $this->redirectToRoute("app_base");
        }
    }
    /** Función para ver el detalle de un pedido introduciendo el id del mismo */
    #[Route('/{codPed}', name: 'app_pedidos_show', methods: ['GET'])]
    public function show(Pedidos $pedido,EntityManagerInterface $entityManager, PedidosProductoRepository $repositoryPedidosProductos): Response
    {
        $productos=$repositoryPedidosProductos->todoProduct($entityManager,$pedido->getCodPed());
        return $this->render('pedidos/show.html.twig', [
            'pedido' => $pedido,
            'productos'=>$productos
        ]);
    }

    
}
