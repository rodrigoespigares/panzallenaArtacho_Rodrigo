<?php

namespace App\Security;

use App\Entity\Restaurante as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserIsVerified implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user):void
    {

        if (!$user instanceof AppUser){
            return;
        }
        if (!$user->isVerified()){
            throw new CustomUserMessageAccountStatusException("Tu cuenta no está verificada. Por favor, verifica tu cuenta antes de iniciar sesión.");
        }
    }
    public function checkPostAuth(UserInterface $user)
    {

    }
}