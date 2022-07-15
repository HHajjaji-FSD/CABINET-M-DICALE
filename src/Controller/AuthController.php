<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/', name: 'app_login')]
    public function index(AuthenticationUtils $utils): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('app_dashboard');
        }

        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        return $this->render('auth/index.html.twig', [
            'error' => $error,
            'last_username'=>$lastUsername
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(){}
}
