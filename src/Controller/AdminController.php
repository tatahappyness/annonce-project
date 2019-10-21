<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



/** 
* @Route("/admin")
* 
*/
class AdminController extends AbstractController
{

    /**
    * @Route("/dashbord", name="admin_dashbord")
    */
    public function dashbord( Security $security)
    {
        // usually you'll want to make sure the user is authenticated first
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('admin/dashbord.html.twig', [
            'page_name' => 'Espace d\'administrateur'
        ]);
    }


    /**
    * @Route("/login_admin", name="admin_login")
    */
    public function login_admin()
    {
        return $this->render('admin/login_admin.html.twig', [
            'controller_name' => 'HomeController',
            'prenom' => 'Lion'
        ]);
    }




    
    /**
    * @Route("/config_site", name="config_site")
    */
    public function config_site()
    {
        return $this->render('admin/config_site.html.twig', [	
            'page_head_title' => 'CONFIGURATION DU SITE',
        ]);
    }
	
	
    
    /**
    * @Route("/trans", name="trans")
    */
    public function trans()
    {
        return $this->render('admin/trans.html.twig', [	
            'page_head_title' => 'TRANSACTION'
        ]);
    }




    
    /**
    * @Route("/client", name="client")
    */
    public function client()
    {
        return $this->render('admin/client.html.twig', [	
            'page_head_title' => 'CLIENT'
        ]);
    }



    
    /**
    * @Route("/abonnement", name="abonnement")
    */
    public function abonnement()
    {
        return $this->render('admin/abonnement.html.twig', [	
            'page_head_title' => 'ABONNEMENT'
        ]);
    }




    
    /**
    * @Route("/service", name="service")
    */
    public function service()
    {
        return $this->render('admin/service.html.twig', [	
            'page_head_title' => 'SERVICE'
        ]);
    }





    
    /**
    * @Route("/dem_devis", name="dem_devis")
    */
    public function dem_devis()
    {
        return $this->render('admin/dem_devis.html.twig', [
            'page_head_title' => 'DEMANDE DE DEVIS'
        ]);
    }

    

    
    /**
    * @Route("/lst_in_pro", name="lst_in_pro")
    */
    public function lst_in_pro()
    {
        return $this->render('admin/lst_in_pro.html.twig', [
            'page_head_title' => 'PROFESSIONNELS'
        ]);
    }

    /**
    * @Route("/m_e_email", name="m_e_email")
    */
    public function m_e_email()
    {
        return $this->render('admin/m_e_email.html.twig', [
            'page_head_title' => 'MODES D’ENVOI D’EMAIL'
        ]);
    }



    /**
    * @Route("/", name="admin_home")
    */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'page_head_title' => 'DASHBOARD'
        ]);
    }


    
    
    /**
    * @Route("/objet_devis", name="objet_devis")
    */
    public function objet_devis()
    {
        return $this->render('admin/objet_devis.html.twig', [	
            'page_head_title' => 'OBJET DE DEVIS'
        ]);
    }

}
