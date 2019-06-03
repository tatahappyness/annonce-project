<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
    * @Route("/login", name="login")
    */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
    * @Route("/", name="home")
    */
    public function home()
    {
        return $this->render('home/home.html.twig');
    }

    /**
    * @Route("/dashbord", name="dashbord")
    */
    public function dashbord()
    {
        return $this->render('admin/dashbord.html.twig');
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }

}
