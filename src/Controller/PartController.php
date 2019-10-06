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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
* @Route("/particulier")
*/
class PartController extends AbstractController
{
    /**
    * @Route("/dashbord", name="particulier_dashbord")
    */
    public function dashbord(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/dashbord.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/lists-ask-projects-devis", name="particulier_ask_project_devis")
    */
    public function askProjectsDevis(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/my-ask-devis-project-list.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/lists-devis-receved-detail", name="particulier_devis_receved")
    */
    public function devisReceved(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/my-devis-receved-detail.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/post-ads-project", name="particulier_post_ads")
    */
    public function adsProjectPostule(Request $request, Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/post-ads.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/lists-ads-postule", name="particulier_ads_postule")
    */
    public function listsAdsPostule(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/my-project-postule-list.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/lists-details-candidates", name="particulier_details_candidates")
    */
    public function listNumberDetailCandidate(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/number-detail-candidature-project.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/post-evaluations", name="particulier_post_evaluations")
    */
    public function evaluations(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/post-evaluations.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/post-comments", name="particulier_post_comments")
    */
    public function comments(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/post-comments.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/post-payements", name="particulier_post_payements")
    */
    public function payements(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return new JsonResponse(['code'=>200, 'info'=> 'Payement effectué!, Vous êtes abonné maintenant, Merci!!'], 200);
    }

    /**
    * @Route("/projects-valid-finish", name="particulier_projects_valid_finish")
    */
    public function validFinishProjects(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/projects-valid-finish.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/projects-detail-valid-finish", name="particulier_projects_detail_valid_finish")
    */
    public function validFinishProjectsDetails(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/detail-valid-finish.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

    /**
    * @Route("/part-password-edit", name="particulier_password_edit")
    */
    public function editPassword(Security $security)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('part/password-edit.html.twig', [
            'controller_name' => 'ESPACE PARTICULIER',
        ]);
    }

}