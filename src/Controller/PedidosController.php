<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\Restaurante;
use App\Form\PedidosType;
use App\Repository\PedidosRepository;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;

#[Route('/pedidos')]
class PedidosController extends AbstractController
{
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

    #[Route('/new', name: 'app_pedidos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $sesion, PedidosRepository $pedidosRepository,RestauranteRepository $restauranteRepository, MailerController $mail, MailerInterface $mailerInterface): Response
    {
        $pedido = new Pedidos();
        $form = $this->createForm(PedidosType::class, $pedido);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $this->getUser();
            if ($user instanceof \App\Entity\Restaurante) {
                $data['time'] = time();
                $dateTime = new DateTime();
                $dateTime->setTimestamp($data['time']);
                // Formatear la fecha y hora en el formato deseado
                $data['fecha'] = $dateTime->format('Y-m-d H:i:s');
                $data['enviado'] = false;
                // Obtén el cod_res del usuario
                $data['restaurante_id'] = $codRes = $user->getCod_res();
            }
            $pedidosRepository->anadir($data,$sesion->get("carrito"),$restauranteRepository, $entityManager);
            
            $mail->sendEmail($mailerInterface,$sesion->get('carrito'));
            $mail->sendEmailPedidos($mailerInterface,$sesion->get('carrito'));
            $sesion->set("carrito",[]);
            return $this->redirectToRoute('app_base', [], Response::HTTP_SEE_OTHER);
        }
        $carrito = $sesion->get('carrito');

        return $this->render('pedidos/new.html.twig', [
            'pedido' => $pedido,
            'form' => $form,
            'cesta' => $carrito,
            
        ]);
    }

    #[Route('/{codPed}', name: 'app_pedidos_show', methods: ['GET'])]
    public function show(Pedidos $pedido): Response
    {
        return $this->render('pedidos/show.html.twig', [
            'pedido' => $pedido,
        ]);
    }

    #[Route('/{codPed}/edit', name: 'app_pedidos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pedidos $pedido, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PedidosType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pedidos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pedidos/edit.html.twig', [
            'pedido' => $pedido,
            'form' => $form,
        ]);
    }

    #[Route('/{codPed}', name: 'app_pedidos_delete', methods: ['POST'])]
    public function delete(Request $request, Pedidos $pedido, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pedido->getCodPed(), $request->request->get('_token'))) {
            $entityManager->remove($pedido);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pedidos_index', [], Response::HTTP_SEE_OTHER);
    }
}
