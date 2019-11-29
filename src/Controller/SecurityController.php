<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DevisRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ConfigsiteRepository;
use App\Repository\ThemeImageRepository;


class SecurityController extends AbstractController
{

    /**
    * @Route("/login", name="login")
    */
    public function login( AuthenticationUtils $authenticationUtils, ThemeImageRepository $themeImageRep, ConfigsiteRepository $configsiteRep, Security $security, CategoryRepository $categoryRep, DevisRepository $devisRep, ArticleRepository $artRep)
    {   

        // On vérifie que l'utilisateur dispose bien du rôle ROLE_ADMIN
        if ($this->isGranted('ROLE_ADMIN')) {
            //return new JsonResponse(['success'=> 'OK'], 200);
            return $this->redirectToRoute('admin_dashbord');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
        }
        // On vérifie que l'utilisateur dispose bien du rôle ROLE_USER_PARTICULAR
        if ($security->isGranted('ROLE_USER_PARTICULAR')) {
        
            return $this->redirectToRoute('particulier_dashbord');
        }
        // On vérifie que l'utilisateur dispose bien du rôle ROLE_USER_PROFESSIONAL
        if ($security->isGranted('ROLE_USER_PROFESSIONAL')) {
        
            return $this->redirectToRoute('pro_dashbord');

        }

       
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
       
            //BEGIN GET TOP DEVIS MORE ASKED
            $popularDevis = $categoryRep->findPopularDevisMoreAsk(array(1=> true));
            $popularDevis = count($popularDevis) > 0 ? $popularDevis : [];

            if (count($popularDevis) <= 0) {

                    $popularDevis = array();
                    $devisPopulars = $devisRep->findTopPopularDevis();
                    $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;

                    if($devisPopulars !== null) {

                        foreach ($devisPopulars as $key => $value) {
                        $popularDevis[] =  $categoryRep->findById($value['category_id']);
                        }

                    }

            }
                //dump($popularDevis);die;
                //END GET POPULA DEVIS
        
            //Get config site
            $configsite = $configsiteRep->findOneByIsActive();

            return $this->render('page/connexion.html.twig', [
                'controller_name' => 'PremuimController', 
                "success" =>  $lastUsername, 
                "error" =>  $error,
                'popularDevis'=> $popularDevis,
                'categories'=> $categories,
                'configsite'=> $configsite,

            ]);
       
    }

    /**
    * Serealize object to string in json
    */
    protected function serialize($object = null)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $json = $serializer->serialize($object, 'json');

        return $json;
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logout()
    {
        //return $this->redirectToRoute('login');
    }

}
