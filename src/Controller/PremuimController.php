<?php

namespace App\Controller;

use App\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
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

/**
* @Route("/premuim")
*/
class PremuimController extends AbstractController
{
    /**
     * @Route("/pro/view_demande_devis", name="premuim_pro_view_demande_devis")
     */
    public function viewdemandedevis()
    {
        return $this->render('premuim/index.html.twig', [
            'controller_name' => 'PremuimController',
        ]);
    }

    /**
    * @Route("/pro/response_demande_devis", name="premuim_pro_response_demande_devis")
    */
    public function responsedemandedevis()
    {
        return $this->render('premuim/index.html.twig', [
            'controller_name' => 'PremuimController',
        ]);
    }

    /**
    * @Route("/pro/response_demande_ads", name="premuim_pro_response_demande_ads")
    */
    public function responsedemandeads()
    {
        return $this->render('premuim/index.html.twig', [
            'controller_name' => 'PremuimController',
        ]);
    }

    /**
    * @Route("/pro/post_jobs", name="premuim_pro_post_job")
    */
    public function postjob()
    {
        return $this->render('premuim/index.html.twig', [
            'controller_name' => 'PremuimController',
        ]);
    }

    /**
    * @Route("/particulier/view_response_devis", name="premuim_particulier_view_response_devis")
    */
    public function viewresponsedevis()
    {
        return $this->render('premuim/index.html.twig', [
            'controller_name' => 'PremuimController',
        ]);
    }

    /**
    * @Route("/particulier/post_ads", name="premuim_particulier_post_ads")
    */
    public function postads()
    {
        return $this->render('premuim/index.html.twig', [
            'controller_name' => 'PremuimController',
        ]);
    }

}
