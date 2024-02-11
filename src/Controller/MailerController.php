<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    public function sendEmail(MailerInterface $mailer,$carrito): Response
    {
        $user = $this->getUser();
        if ($user instanceof \App\Entity\Restaurante) {
            $email = $user->getEmail();
        
        }
        $htmlContent = $this->renderView('/mailer/mail.html.twig', ['cesta' => $carrito]);
        try{
        $email = (new Email())
            ->from(new Address('no-replay@tripallena.com','Departamento de pedidos'))
            ->to($email)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Hola '.$email.' su pedido ha sido tramitado.')
            ->text('Sending emails is fun again!')
            ->html($htmlContent);
            $mailer->send($email);
        
            return $this->render('/mailer/index.html.twig');

        } catch (\Exception $e) {
            // Manejar el error
            return new Response('Error al enviar el correo electrónico: ' . $e->getMessage());
        }
    }
    public function sendEmailPedidos(MailerInterface $mailer,$carrito): Response
    {
        
        
        try{

        $htmlContent = $this->renderView('/mailer/mail.html.twig', ['cesta' => $carrito]);
        $email = (new Email())
            ->from(new Address('no-replay@tripallena.com','Departamento de pedidos'))
            ->to('pedidos@tripallena.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Hay un nuevo pedido')
            ->text('Sending emails is fun again!')
            ->html($htmlContent);
            $mailer->send($email);
        
            return $this->render('/mailer/index.html.twig');

        } catch (\Exception $e) {
            // Manejar el error
            return new Response('Error al enviar el correo electrónico: ' . $e->getMessage());
        }

        
    }
}
