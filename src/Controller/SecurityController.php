<?php

namespace App\Controller;

use App\Repository\RestauranteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, RestauranteRepository $restauranteRepository): Response
    {
        // Obtener el último nombre de usuario ingresado por el usuario
        $lastUsername = $authenticationUtils->getLastUsername();

        // Obtener el error de inicio de sesión si lo hay
        $error = $authenticationUtils->getLastAuthenticationError();


        if ($this->getUser() ) {
            return $this->redirectToRoute('app_base');
        }

        // Renderizar la plantilla de inicio de sesión
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
