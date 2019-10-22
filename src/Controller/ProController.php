<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Devis;
use App\Entity\Customer;
use App\Entity\Transaction;
use App\Entity\ReponsePostAds;
use App\Entity\Abonnement;
use App\Entity\DevisAccept;
use App\Entity\DevisFinish;
use App\Entity\DevisValid;
use App\Entity\DevisViewed;
use App\Entity\Images;
use App\Entity\Documment;
use App\Entity\Services;
use App\Entity\Labels;
use App\Entity\Videos;
use App\Entity\Offer;
use App\Entity\Conseil;
use App\Entity\Evaluations;
use App\Entity\GuidePrice;
use App\Entity\ChantierOfMouth;
use App\Entity\SiteInternet;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use App\Repository\AbonnementRepository;
use App\Repository\ArticleRepository;
use App\Repository\ServicesRepository;
use App\Repository\CustomerRepository;
use App\Repository\DevisRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\EvaluationsRepository; 
use App\Repository\CitiesRepository;
use App\Repository\EmojiRepository;
use App\Repository\DevisAcceptRepository;
use App\Repository\DevisValidRepository;
use App\Repository\DevisFinishRepository;
use App\Repository\DevisViewedRepository;
use App\Repository\DocummentRepository;
use App\Repository\ImagesRepository;
use App\Repository\SiteInternetRepository;
use App\Repository\LabelsRepository;
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
use Symfony\Component\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
* @Route("/pro")
*/
class ProController extends AbstractController
{
    /**
    * @Route("/dashbord", name="pro_dashbord")
    * @param $user to find pro owner infos
    */
    public function dashbord(Security $security, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $services = $serviceRep->findByUser($security->getUser());

        $array = Array();
        foreach ($services as $key => $value) {
        $array[] = $value->getCategoryId();
        }

        $categoryId =  $array;
        $arrayData1 = array( 1=>  ($categoryId), 
                            2=> $security->getUser()->getZipCode(), 
                            3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId)
                            );

        $devis = $devisRep->findByZipCodeAndCity($arrayData1);
        $nbdevis = count($devis);

        $arrayData2 = array(1=>  ($categoryId), 
                            2=> ($categoryId), 3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId), 5=> $security->getUser()->getZipCode()
                            );
        $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData2);
        $postsAds = count( $postsAdsArray ) !== 0 ? $postsAdsArray : null;
        return $this->render('pro/dashbord.html.twig', [
            'numberDevis' => $nbdevis,
            'postAds'=> $postsAds,
             'nbProjectDispo'=> count($postsAds),
             'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/lists-projects-disponible", name="pro_dispos_projects")
    */
    public function dispoProjects(Request $request, Security $security, CategoryRepository $catRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisRepository $devisRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        //  Initial the data critical in database to find
        
        //HERE GET PROJECT DISPO ESPECTED DIRECTLY BY PRO SPECIALITY or Zipcage or Departement
    
        $services = $serviceRep->findByUser($security->getUser());
        $array = Array();
        foreach ($services as $key => $value) {
           $array[] = $value->getCategoryId();
        }
        $categoryId =  $array;
        $arrayData = array(1=>  ($categoryId), 
                            2=> ($categoryId), 3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId), 5=> $security->getUser()->getZipCode()
                            );          
        $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData);
        $postsAds = count( $postsAdsArray ) !== 0 ? $postsAdsArray : null;
        //dump($postsAds);die;

        if($postsAds !== null && !is_null($request->query->get('switch_periodity'))) {
            $arrayPostAds = Array();
            foreach ($postsAds as $key => $value) {

                $datetime1 = $value->getPostAdsDateCrea();
                $datetime2 = new \DateTime('now');
                $interval = $datetime1->diff($datetime2);

                    if ((int) $interval->format('%R%a') < (int) $request->query->get('switch_periodity')) {
                        $arrayPostAds[$key] = ['id'=> $value->getId(), 
                                                'title'=> $value->getCategoryId()->getCategTitle(),
                                                'firstname'=> $value->getPostUserId()->getFirstname(),
                                                'city'=> $value->getCity()->getVilleNomReel(),
                                                'description'=> $value->getPostAdsTravauxDescription(),
                                                'date'=> $value->getPostAdsDateCrea()
                                                ];
                    }
                    else {
                        $arrayPostAds[$key] = ['id'=> $value->getId(), 
                                                'title'=> $value->getCategoryId()->getCategTitle(),
                                                'firstname'=> $value->getPostUserId()->getFirstname(),
                                                'city'=> $value->getCity()->getVilleNomReel(),
                                                'description'=> $value->getPostAdsTravauxDescription(),
                                                'date'=> $value->getPostAdsDateCrea()->format('d/m/Y H:i:s')                           
                                                ];
                    }
                   
            }
            return new JsonResponse($arrayPostAds, 200);
        }

        return $this->render('pro/projects-dispos.html.twig', [
            'postAds' => $postsAds, 
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'user'=> $security->getUser(),
        ]);

    }

    /**
    * @Route("/show-one-detail-ads-project/{id}", name="pro_one_detail_ads_projects")
    */
    public function detailAdsProjects($id = null, Security $security, CategoryRepository $catRep, PostRepository $postRep, AbonnementRepository $abonnementRep, CustomerRepository $customRep, ServicesRepository $serviceRep, DevisRepository $devisRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        //here we need testing user abonnement and add post status ads in post viewed
        $customer = $customRep->findByUser($security->getUser());
        $post = $postRep->findById((int) $id);
        
        if (!is_null($post) && !is_null($customer)) {

            $myservice = $serviceRep->findByUserAndCategoryId(array(1=> $security->getUser(), 2=> $post->getCategoryId()));
            $arrayCriticals = array(1=>  $customer, 2=> $myservice); // prepare query to get abonnement here!

            if ($myservice->getIsActived() == true && $abonnementRep->isPremiumAndDateExpireValid($arrayCriticals)) 
            {
                $devis = $devisRep->findById((int) $id);
                //dump($devis);die;
                return $this->render('premuim/info-ads-premuim.html.twig', [
                    'post' => $post, 
                    'isAbonned'=> true,  
                    'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
                    'user'=> $security->getUser(),
                ]);
            }
        }

        return $this->render('premuim/info-ads-premuim.html.twig', [
            'post' => $post, 'isAbonned'=> false, 
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/send-response-ads-project", name="pro_send_response_ads_projects")
    */
    public function responseAdsProjects(Request $request, Security $security, PostRepository $postRep, UserRepository $userRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if(!is_null($request->request->get('post_id') && !is_null($request->request->get('particular_id')) && !is_null($request->request->get('response_message'))))
        {
            try {

                $em = $this->getDoctrine()->getManager();
                $em->beginTransaction();
                $responsePosAds = new ReponsePostAds();
                $responsePosAds
                    ->setUserPartId($userRep->findOneById((int) $request->request->get('particular_id')))
                    ->setUserProId($security->getUser())
                    ->setPostAdsId($postRep->findById((int) $request->request->get('post_id')))
                    ->setMessage($request->request->get('response_message'))
                    ->setDateCrea(new \DateTime('now'));

                $em->persist($responsePosAds);
                $em->flush();
                $em->commit();
                return new JsonResponse(array('code'=> 200, 'infos'=> 'Votre message a été bien envoyé!'), 200);

            } catch (\Throwable $th) {
                return new JsonResponse(array('code'=> 500, 'infos'=> $th->getMessage()), 500);
            }
        }
    
    }

    /**
    * @Route("/devis-receved-lists", name="pro_devis_receved_lists")
    */
    public function devisReceved(Security $security, DevisRepository $devisRep, ServicesRepository $serviceRep, CustomerRepository $customRep, DevisAcceptRepository $devisAcceptrep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        //check user if is Free yet to receve 5 devis free
        $datetime1 = $security->getUser()->getFreeDateExpire();
        $datetime2 = new \DateTime('now');
        $interval = $datetime1->diff($datetime2);

        $services = $serviceRep->findByUser($security->getUser());

        $devisAcceptArray =  $devisAcceptrep->findByUserId($security->getUser());   
        $devisAccept = count($devisAcceptArray) > 0 ? $devisAcceptArray : null;

        $array = Array();
        foreach ($services as $key => $value) {
        $array[] = $value->getCategoryId();
        }

        $categoryId =  $array;
        $arrayData = array( 1=>  ($categoryId), 
                            2=> $security->getUser()->getZipCode(), 
                            3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId)
                            );
       
        if ((int) $interval->format('%R%a') <= 0) 
        {
            $devis = $devisRep->findByZipCodeAndCity($arrayData, 5);

            return $this->render('pro/devis-receved-list.html.twig', [
                'devis' => $devis, 'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
                'isAbonned'=> true, 'devisAccept'=>  $devisAccept,
                'user'=> $security->getUser(),
            ]);

        }
        
        $devis = $devisRep->findByZipCodeAndCity($arrayData);

        return $this->render('pro/devis-receved-list.html.twig', [
            'devis' => $devis, 'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'isAbonned'=> false, 'devisAccept'=>  $devisAccept,
            'user'=> $security->getUser(),
        ]);

    }

    /**
    * @Route("/devis-receved-detail/{id}", name="pro_devis_receved_detail")
    */
    public function devisRecevedDetail($id = null, Security $security, CustomerRepository $customRep, AbonnementRepository $abonnementRep, ServicesRepository $serviceRep, DevisRepository $devisRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        //dump($id);die;
        //check user if is Free yet
        $datetime1 = $security->getUser()->getFreeDateExpire();
        $datetime2 = new \DateTime('now');
        $interval = $datetime1->diff($datetime2);
       
        if ($id !== null && (int) $interval->format('%R%a') <= 0) 
        {
            $devis = $devisRep->findById((int) $id);
            return $this->render('premuim/devis-receved-detail.html.twig', [
                'devis' => $devis, 'isAbonned'=> true, 
                'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
                'user'=> $security->getUser(),
            ]);

        }

        // We need here to verify user if it is our customer when we can set devis user destinations
        $customer = $customRep->findByUser($security->getUser());
        $devis = $devisRep->findById((int) $id);
        
        if ($id !== null && !is_null($devis) && !is_null($customer)) {

            $myservice = $serviceRep->findByUserAndCategoryId(array(1=> $security->getUser(), 2=> $devis->getNatureProject()->getArticleCategId()));
            $arrayCriticals = array(1=>  $customer, 2=> $myservice); // prepare query to get abonnement here!

            if ($myservice->getIsActived() == true && $abonnementRep->isPremiumAndDateExpireValid($arrayCriticals)) 
            {
                $devis = $devisRep->findById((int) $id);
                //dump($devis);die;
                return $this->render('premuim/devis-receved-detail.html.twig', [
                    'devis' => $devis, 'isAbonned'=> true, 
                    'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
                    'user'=> $security->getUser(),
                ]);
            }
        }
        if ($devis == null) {
            return  $this->redirectToroute('pro_devis_receved_lists');
        }
        $service = $serviceRep->findByUserAndCategoryId(array(1=> $security->getUser(), 2=> $devis->getNatureProject()->getArticleCategId()));
        return $this->render('premuim/devis-receved-detail.html.twig', [
            'devis' => $devis, 'isAbonned'=> false,
            'service'=>  $service,
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'user'=> $security->getUser(),
        ]);
    }
    
    /**
    * @Route("/do-accept-project", name="pro_do_accept_devis")
    */
    public function acceptDevis(Request $request, DevisRepository $devisRep, Security $security, CustomerRepository $customRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if($_GET) {
            
            if(!is_null($request->query->get('devisId'))) {
               
                try {
                    
                    $devis = $devisRep->findById((int) $request->query->get('devisId'));
                    $em = $this->getDoctrine()->getManager();
                    $em->beginTransaction();
                    $devisAccept = new DevisAccept();
                    $devisAccept
                        ->setDevisId($devis)
                        ->setUserId($security->getUser())
                        ->setDateCrea(new \DateTime('now'));
                        $em->persist( $devisAccept);
                        $em->flush();
                    $em->commit();
                    return new JsonResponse(array('code'=> 200, 'infos'=> 'Vous avez accepté ce devis ' . $devis->getCategoryId()->getCategTitle()), 200);

                } catch (\Throwable $th) {
                    return new JsonResponse(array('code'=> 500, 'infos'=> $th->getMessage()), 500);   
                }
            }

        }

    }

    /**
    * @Route("/do-valid-project", name="pro_do_valid_devis")
    */
    public function validDevis(Request $request, Security $security, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep )
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if($_GET) {
            
            if(!is_null($request->query->get('devisAcceptId'))) {
               
                try {
                    
                    $devisAccept = $devisAcceptRep->findById((int) $request->query->get('devisAcceptId'));
                    $em = $this->getDoctrine()->getManager();
                    $em->beginTransaction();
                    $devisValid = new DevisValid();
                    $devisValid
                        ->setDevisAcceptId($devisAccept)
                        ->setUserId($security->getUser())
                        ->setDateCrea(new \DateTime('now'));
                        $em->persist( $devisValid);
                        $em->flush();
                    $em->commit();
                    return new JsonResponse(array('code'=> 200, 'infos'=> 'Vous avez validé ce devis ' . $devisAccept->getDevisId()->getCategoryId()->getCategTitle()), 200);

                } catch (\Throwable $th) {
                    return new JsonResponse(array('code'=> 500, 'infos'=> $th->getMessage()), 500);   
                }
            }

        }
        
    }

    /**
    * @Route("/do-finish-project", name="pro_do_finish_devis")
    */
    public function finishDevis(Request $request, Security $security, DevisRepository $devisRep, DevisValidRepository $devisValidRep )
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if($_GET) {
            
            if(!is_null($request->query->get('devisFinishId'))) {
               
                try {
                    
                    $devisValid = $devisValidRep->findById((int) $request->query->get('devisFinishId'));
                    $em = $this->getDoctrine()->getManager();
                    $em->beginTransaction();
                    $devisFinish = new DevisFinish();
                    $devisFinish
                        ->setDevisValid($devisValid)
                        ->setUserId($security->getUser())
                        ->setDateCrea(new \DateTime('now'));
                        $em->persist( $devisFinish);
                        $em->flush();
                    $em->commit();
                    return new JsonResponse(array('code'=> 200, 'infos'=> 'Vous avez terminé ce devis ' . $devisValid->getDevisAcceptId()->getDevisId()->getCategoryId()->getCategTitle()), 200);

                } catch (\Throwable $th) {
                    return new JsonResponse(array('code'=> 500, 'infos'=> $th->getMessage()), 500);   
                }
            }

        }

        
    }


    /**
    * @Route("/lists-projects-accepted", name="pro_projects_accepted")
    */
    public function projectsAccepted(Security $security, ServicesRepository $serviceRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep) 
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        
        $devisAcceptArray = $devisAcceptRep->findByUserId($security->getUser());
        $devisValidArray = $devisValidRep->findByUserId($security->getUser());
        $devisFinishArray = $devisFinishRep->findByUserId($security->getUser());

        $devisAccept = count( $devisAcceptArray) > 0 ?  $devisAcceptArray : null;
        $devisValid = count( $devisValidArray) > 0 ?  $devisValidArray : null;
        $devisFinish = count( $devisFinishArray) > 0 ?  $devisFinishArray : null;

        return $this->render('pro/project-accepted.html.twig', [
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'devisAccept'=> $devisAccept,
            'devisValid'=> $devisValid,
            'devisFinish'=> $devisFinish,
            'user'=> $security->getUser(),

        ]);
    }

    /**
    * @Route("/lists-my-evaluations", name="pro_evaluations")
    */
    public function proEvaluations(Security $security, CustomerRepository $customRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');



        return $this->render('pro/pro-evaluations.html.twig', [
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/show-my-profil", name="pro_show_profil")
    */
    public function profil(Security $security, DocummentRepository $docummentRep, EvaluationsRepository $evaluationRep, ImagesRepository $imageRep, CustomerRepository $customRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $services = $serviceRep->findByUser($security->getUser());

        $array = Array();
        foreach ($services as $key => $value) {
        $array[] = $value->getCategoryId();
        }

        $categoryId =  $array;
        $arrayData1 = array( 1=>  ($categoryId), 
                            2=> $security->getUser()->getZipCode(), 
                            3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId)
                            );

        $devis = $devisRep->findByZipCodeAndCity($arrayData1);
        $nbdevis = count($devis);

        $arrayData2 = array(1=>  ($categoryId), 
                            2=> ($categoryId), 3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId), 5=> $security->getUser()->getZipCode()
                            );
        $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData2);
        $postsAds = count( $postsAdsArray ) !== 0 ? $postsAdsArray : null;

        //get Document

        //get label
        //get image realize


        return $this->render('pro/profil.html.twig', [
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'postAds'=> $postsAds,
            'nbProjectDispo'=> count($postsAds),
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/edit-profil-pros", name="pro_edit_profil-pros")
    */
    public function editProfil(Request $request, Security $security, UserRepository $user)
    {
            if (!is_null($request->files->get('file-upload')) ) {

                $file = $request->files->get('file-upload');
                
                $output_dir = $this->getParameter('profil_directory');
                $arr_extensions = ["jpeg", "jpg", "png"];
                //@Assert\File(maxSize="6000000")

                if (!(in_array($file->getClientOriginalExtension(), $arr_extensions))) 
                {
                    return new JsonResponse(array('code'=> 401, 'infos'=> 'Type de fichier n\'est pas autorisé'), 401);
                }
                   
                try { 
                    // generate a random name for the file but keep the extension
                    $filename = uniqid().".".$file->getClientOriginalExtension();
                    $file->move( $output_dir, $filename); // move the file to a path

                    $user = $security->getUser();
                    $user
                        ->setProfilImage($filename);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->merge($user);
                    $entityManager->flush();

                    return new JsonResponse(array('code'=> 200, 'info'=>  $filename), 200);

                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
                }
            }
        return new JsonResponse(['code'=> 500, "info" => 'Vous avez fait une movaise requête!'], 500);
    }

    /**
    * @Route("/show-coordonation", name="pro_coordonation")
    */
    public function coordonation(Security $security, CustomerRepository $customRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('pro/my-coordonation.html.twig', [
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/company-edit", name="pro_company_edit")
    */
    public function editCompany(Request $request, Security $security, CustomerRepository $customRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('pro/my-company-edit.html.twig', [
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/coordonation-edit", name="pro_cordonation_edit")
    */
    public function editCoordonation(Request $request, Security $security, CitiesRepository $cityRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        
        if($_POST) {
           
            if (!is_null($request->request->get('city')) && !is_null($request->request->get('zipcode')) && !is_null($request->request->get('company_name')) && !is_null($request->request->get('_username')) && !is_null($request->request->get('firstname')) && !is_null($request->request->get('phone')) && !is_null($request->request->get('_email'))) {
                
                $city = $cityRep->findById((int) $request->request->get('city'));
                $user = $security->getUser();
                $user
                ->setUsername($request->request->get('_username'))
                    ->setFirstname($request->request->get('firstname'))
                    ->setMobile($request->request->get('phone'))
                    ->setEmail($request->request->get('_email'))
                    ->setZipCode($request->request->get('zipcode'))
                    ->setUserCity($city)
                    ->setCompanyName($request->request->get('company_name'));
                //->setLat($request->request->get('latitude'))
                    //->setog($request->request->get('longitude'))
                    // ->setPassword($passwordEncoder->encodePassword(
                    //         $user,
                    //         $request->request->get('_password')
                    //     ));
                    $entityManager = $this->getDoctrine()->getManager();
                try {
    
                    $entityManager->merge($user);
                    $entityManager->flush();
                    return new JsonResponse(['code'=> 200, "infos" => 'Modification effectuée!'], 200);
                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'infos' => $e->getMessage()], 500);
                }
            }

        }

        
        $services = $serviceRep->findByUser($security->getUser());

        $array = Array();
        foreach ($services as $key => $value) {
        $array[] = $value->getCategoryId();
        }

        $categoryId =  $array;
        $arrayData1 = array( 1=>  ($categoryId), 
                            2=> $security->getUser()->getZipCode(), 
                            3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId)
                            );

        $devis = $devisRep->findByZipCodeAndCity($arrayData1);
        $nbdevis = count($devis);

        $arrayData2 = array(1=>  ($categoryId), 
                            2=> ($categoryId), 3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId), 5=> $security->getUser()->getZipCode()
                            );
        $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData2);
        $postsAds = count( $postsAdsArray ) !== 0 ? $postsAdsArray : null;
       
        return $this->render('pro/my-coordonation-edit.html.twig', [
            'numberDevis' => $nbdevis,
            'postAds'=> $postsAds,
            'nbProjectDispo'=> count($postsAds),
            'user'=> $security->getUser(),
            
        ]);
    }

    /**
    * @Route("/geolocation-map-edit", name="pro_geolocation_map_edit")
    */
    public function editGeolocationMap(Request $request, Security $security, CustomerRepository $customRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('pro/my-geolocation-map-edit.html.twig', [
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/password-edit", name="pro_password_edit")
    */
    public function editpassword(Request $request, Security $security, CustomerRepository $customRep,  ServicesRepository $serviceRep,  DevisRepository $devisRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        return $this->render('pro/my-password-edit.html.twig', [
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/image-chantier-realize-edit", name="pro_image_realize_edit")
    */
    public function editImagesRealize(Request $request, Security $security, ArticleRepository $articleRep,  CitiesRepository $cityRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
       
        //UPLOAD IMAGES
        $file = $request->files->get('fileImages');
        $articleId = $request->request->get('imagesNatureTitle');
        
        if(!is_null($file) && !is_null($articleId))
        {
            $output_dir = $this->getParameter('images_directory');
            $arr_extensions = ["jpg", "jpeg", "jpg", "png", "gif"];
            //@Assert\File(maxSize="6000000")

            if (!(in_array($file->getClientOriginalExtension(), $arr_extensions))) 
            {
                return new JsonResponse(array('code'=> 401, 'infos'=> 'Type de fichier n\'est pas autorisé'), 401);
            }

            // $request->query->get("image_nature_title")
            // Convert to base64 
            // $video_base64 = base64_encode(file_get_contents($file) );
            // $image = 'data:image/'.$file->getClientOriginalExtension().';base64,'.$image_base64;
           
            try {

                $em = $this->getDoctrine()->getManager();
                $em->beginTransaction();
                // generate a random name for the file but keep the extension
                $filename = uniqid().".".$file->getClientOriginalExtension();
                $file->move( $output_dir, $filename); // move the file to a path
                $article = $articleRep->findById((int) $articleId);
                $image = new Images();
                $image
                    ->setUserId($security->getUser())
                    ->setArticleTitle($article)
                    ->setDateCrea(new \DateTime('now'));    

                $em->persist($image); 
                $em->flush();
                $em->commit();
                return new JsonResponse(array('code'=> 200, 'infos'=>  $filename), 200);

            } catch (\Exception $e) {
                return new JsonResponse(['code'=> 500 ,'infos' => $e->getMessage()], 500);
            }
        }

  
        $services = $serviceRep->findByUser($security->getUser());

        $array = Array();
        foreach ($services as $key => $value) {
        $array[] = $value->getCategoryId();
        }

        $categoryId =  $array;
        $arrayData1 = array( 1=>  ($categoryId), 
                            2=> $security->getUser()->getZipCode(), 
                            3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId)
                            );

        //get list articles by lists category array
        $articles = $articleRep->findByCategoryArray(array(1=> $array));
        $articles = count($articles) ? $articles : null;

        $devis = $devisRep->findByZipCodeAndCity($arrayData1);
        $nbdevis = count($devis);

        $arrayData2 = array(1=>  ($categoryId), 
                            2=> ($categoryId), 3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId), 5=> $security->getUser()->getZipCode()
                            );
        $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData2);
        $postsAds = count( $postsAdsArray ) !== 0 ? $postsAdsArray : null;


        return $this->render('pro/image-chantie-realize-edit.html.twig', [
            'numberDevis' => $nbdevis,
            'postAds'=> $postsAds,
            'nbProjectDispo'=> count($postsAds),
            'user'=> $security->getUser(),
            'articles'=> $articles,
        ]);
    }

    /**
    * @Route("/video-chantier-realize-edit", name="pro_video_realize_edit")
    */
    public function editVideosRealize(Request $request, Security $security, CustomerRepository $customRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        //UPLOAD VIDEOS 
        // do var_dump($request->files->all()); if you need to know if the file is being uploaded.
        $file = $request->files->get('fileVideos');
        $articleId = $request->query->get('videosNatureTitle');

        $output_dir = $this->getParameter('videos_directory');

        $array_extensions = ['mp4', 'ogg'];
        $arr_file_types = ['video/mp4', 'video/ogg'];

        if(!is_null($file))
        {	
          
            if (!(in_array($file->getClientOriginalExtension(), $array_extensions))) {
                return new JsonResponse(array('code'=> 401, 'infos'=> 'Type de fichier n\'est pas autorisé'), 200);
            }

                // Convert to base64 
                // $video_base64 = base64_encode(file_get_contents($file) );
                // $image = 'data:image/'.$file->getClientOriginalExtension().';base64,'.$image_base64;

                try {
                    
                    // generate a random name for the file but keep the extension
                    $filename = uniqid().".".$file->getClientOriginalExtension();
                    $file->move( $output_dir, $filename); // move the file to a path
              
                    return new JsonResponse(array('code'=> 200, 'infos'=>  $filename), 200);

                } catch (\Throwable $th) {
                    return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
                }
            }

        return $this->render('pro/video-chantie-realize-edit.html.twig', [
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/document-file-edit", name="pro_document_file_edit")
    */
    public function editDocumentFile(Request $request, Security $security, DocummentRepository $documentRep, CitiesRepository $cityRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if (!is_null($request->files->get('fileDocumentCompany')) && !is_null($request->request->get('document_title'))  ) {
           // dump($request->files->get('fileDocumentCompany'));die;
            $file = $request->files->get('fileDocumentCompany');
        
            $output_dir = $this->getParameter('documents_directory');
            $arr_extensions = ["pdf", "docx", "doc"];
            //@Assert\File(maxSize="6000000")

            if (!(in_array($file->getClientOriginalExtension(), $arr_extensions))) 
            {
                return new JsonResponse(array('code'=> 401, 'info'=> 'Type de fichier n\'est pas autorisé'), 401);
            }
           
            try { 

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->beginTransaction();
                // generate a random name for the file but keep the extension
                $filename = uniqid().".".$file->getClientOriginalExtension();
                $file->move( $output_dir, $filename); // move the file to a path

                $user = $security->getUser();
                $document = new Documment();
                $document
                    ->setUserId($user)
                    ->setTitle($request->request->get('document_title'))
                    ->setName($filename)
                    ->setDateCrea(new \DateTime('now'));
             
                $entityManager->persist($document);
                $entityManager->flush();
                $entityManager->commit();

                return new JsonResponse(array('code'=> 200, 'info'=>  $filename), 200);

            } 
            catch (\Exception $e) {
                return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
            }
        }
        // return new JsonResponse(['code'=> 500, "info" => 'Vous avez fait une movaise requête!'], 500);
        
        $services = $serviceRep->findByUser($security->getUser());

        $array = Array();
        foreach ($services as $key => $value) {
        $array[] = $value->getCategoryId();
        }

        $categoryId =  $array;
        $arrayData1 = array( 1=>  ($categoryId), 
                            2=> $security->getUser()->getZipCode(), 
                            3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId)
                            );

        $devis = $devisRep->findByZipCodeAndCity($arrayData1);
        $nbdevis = count($devis);

        $arrayData2 = array(1=>  ($categoryId), 
                            2=> ($categoryId), 3=> $security->getUser()->getUserCity(),
                            4=>  ($categoryId), 5=> $security->getUser()->getZipCode()
                            );
        $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData2);
        $postsAds = count( $postsAdsArray ) !== 0 ? $postsAdsArray : null;
        return $this->render('pro/my-document-file-edit.html.twig', [
            'numberDevis' => $nbdevis,
            'postAds'=> $postsAds,
            'nbProjectDispo'=> count($postsAds),
            'user'=> $security->getUser(),
        ]);
    }

    /**
     * @Route("/label-quality-edit", name="pro_label_quality_edit")
    */
    public function editLabelQuality(Request $request, Security $security, LabelsRepository $labelRep, CitiesRepository $cityRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {

        if (!is_null($request->files->get('file_image_label')) && !is_null($request->request->get('label_quality_title'))  ) {
            // dump($request->files->get('fileDocumentCompany'));die;
                $file = $request->files->get('file_image_label');
                $output_dir = $this->getParameter('profil_directory');
                $arr_extensions = ["jpg", "png", "jpeg", "JPEG"];
                //@Assert\File(maxSize="6000000")
    
                if (!(in_array($file->getClientOriginalExtension(), $arr_extensions))) 
                {
                    return new JsonResponse(array('code'=> 401, 'info'=> 'Type de fichier n\'est pas autorisé'), 401);
                }
               
                try { 
    
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->beginTransaction();
                    // generate a random name for the file but keep the extension
                    $filename = uniqid().".".$file->getClientOriginalExtension();
                    $file->move( $output_dir, $filename); // move the file to a path
    
                    $user = $security->getUser();
                    $label = new Labels();
                    $label
                        ->setUserId($user)
                        ->setTitle($request->request->get('label_quality_title'))
                        ->setName($filename)
                        ->setDateCrea(new \DateTime('now'));
                 
                    $entityManager->persist($label);
                    $entityManager->flush();
                    $entityManager->commit();
    
                    return new JsonResponse(array('code'=> 200, 'info'=>  $filename), 200);
    
                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
                }
            }
            return new JsonResponse(['code'=> 500, "info" => 'Vous avez fait une movaise requête!'], 500);
            
    }


    /**
    * @Route("/post-payements/{id}", name="pro_post_payements")
    */
    public function payements($id = null, Request $request, Security $security, ServicesRepository $serviceRep, CustomerRepository $customRep, AbonnementRepository $abennementRep, OfferRepository $offerRep )
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if ($_POST) {
            
            if (!is_null($request->request->get('stripeToken'))) {

                // Set your secret key: remember to change this to your live secret key in production
                // See your keys here: https://dashboard.stripe.com/account/apikeys

                \Stripe\Stripe::setApiKey('sk_test_vKh2QpGMT8Dv89CiAzpS8wbl00vsdGEYkc');
                //Token is created using Checkout or Elements!
                //Get the payment token ID submitted by the form:
                $token = $request->request->get('stripeToken');

                $service = $serviceRep->findById((int) $request->request->get('service_id'));
                //dump( $service);die;
                $custom = $customRep->findById($security->getUser()->getId());
                $custId = $custom->getCustomerId();
                $email = $custom->getEmail();
                if (is_null($custId)) {
                    //Create new customer
                    $customer = \Stripe\Customer::create([
                        'email' => $request->request->get('email'),
                        'source' => $token,
                        'name' => $request->request->get('name')
                    ]);
                    $custId = $customer->id;
                    $email = $request->request->get('email');
                    $newCustom = new Customer();
                    $newCustom
                        ->setUserId($security->getUser()->getId())
                        ->setCustomerId($custId)
                        ->setEmail($email)
                        ->setName($request->request->get('name'))
                        ->setDateCrea(new \DateTime('now'));

                    $em =  $this->getDoctrine()->getManager();
                    $em->beginTransaction();
                    $em->persist($newCustom);
                    $em->flush();
                    
                    $custom = $customRep->findById($security->getUser()->getId());
                    $custId = $custom->getCustomerId();
                    $email = $custom->getEmail();
                    $em->commit();
                    
                }
                //dump($customer);die;
                if (!is_null($custId)) {
                    //Do pay amount
                    $charge = \Stripe\Charge::create([
                        'customer' => $custId,
                        'amount' => (float) $request->request->get('montant_paye'),
                        'currency' => 'eur',
                        'description' => 'Payement de service ' . $service->getCategoryId()->getCategTitle() . ' par ' . $email,
                        //'source' => $token,
                        'statement_descriptor' => 'Client professionnel',
                        //'capture' => false,
                        //'metadata' => ['order_id' => 6735],
                    ]);

                    //dump($charge);die;
                    //We need to update date_validity_abonnement and adding transaction 
                    $transaction = new Transaction();
                    $abonnement = $abennementRep->findOneByCustomerAndService(array(1=> $custom, 2=> $service));

                    $date = new \DateTime('+1year');
                    //dump($date);die;

                    if (is_null($abonnement)) {

                        $abonnement = new Abonnement();
                        $abonnement
                            ->setCustomerId($custom)
                            ->setServiceId($service)
                            //->set($service)
                            ->setDatePayement(new \DateTime('now'))
                            ->setDateExpire($date);
                    }

                    $abonnement
                    //->set($service)
                    ->setDatePayement(new \DateTime('now'))
                    ->setDateExpire($date);

                    $transaction
                        ->setTransactionId($charge->id)
                        ->setCustomerId($custom)
                        ->setDescription($charge->description)
                        ->setAmount($charge->amount)
                        ->setDateCrea(new \DateTime('now'));

                    $service
                        ->setIsActived(true);

                    $em =  $this->getDoctrine()->getManager();
                    try {
                        $em->beginTransaction();
                        $em->persist($abonnement);
                        $em->flush();

                        $em->persist($transaction);
                        $em->flush();

                        $em->merge($service);
                        $em->flush();
                        $em->commit();
                        return new JsonResponse(['code'=>200, 'info'=> 'Payement effectué!, Vous êtes abonné maintenant, Merci!!'], 200);

                    } catch (\Throwable $th) {
                        return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
                    }
                }

                // $charge = \Stripe\Charge::retrieve('ch_mPrAdwBPVO80x4ddHSPM');
                // $charge->capture
                return new JsonResponse(['code'=>200, 'info'=> 'Votre solde peut être inssuffisant, Veuillez verifier votre solde'], 200);
            }
        }
        //$offer = $offerRep->findAllArray();
        $offer = $offerRep->findById(1);
        return $this->render('premuim/strip-form.html.twig', [
            'serviceId' => $id, 'offer'=> $offer
        ]);   
    }

    /**
    * @Route("/lists-services", name="pro_services")
    */
    public function services(Security $security, ServicesRepository $serviceRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        
        $devisAcceptArray = $devisAcceptRep->findByUserId($security->getUser());
        $devisValidArray = $devisValidRep->findByUserId($security->getUser());
        $devisFinishArray = $devisFinishRep->findByUserId($security->getUser());

        $devisAccept = count( $devisAcceptArray) > 0 ?  $devisAcceptArray : null;
        $devisValid = count( $devisValidArray) > 0 ?  $devisValidArray : null;
        $devisFinish = count( $devisFinishArray) > 0 ?  $devisFinishArray : null;

        $servicesArray = $serviceRep->findAll();
        $services = !is_null($servicesArray) ? $servicesArray : null;
        return $this->render('pro/services.html.twig', [
            'services' => $services,
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'devisAccept'=> $devisAccept,
            'devisValid'=> $devisValid,
            'devisFinish'=> $devisFinish,
            'user'=> $security->getUser(),
        ]);
    }

    /**
    * @Route("/delete-service/{id}", name="pro_delete_service")
    */
    public function deleteService($id = null, Security $security, ServicesRepository $serviceRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
           try {
            $em->beginTransaction();
            $service = $serviceRep->findById((int) $id);
            $em->remove($service);
            $em->flush();
            $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
        return $this->redirectToRoute('pro_services');
    }

    /**
    * @Route("/guid-price-add/{id}", name="pro_guid_price_add")
    */
    public function addGuidePrice($id = null, Security $security, ServicesRepository $serviceRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
            try {
                $em->beginTransaction();
                $service = $serviceRep->findById((int) $id);
                $em->remove($service);
                $em->flush();
                $em->commit();
                return new JsonResponse(['code'=> 200 ,'info' => ''], 200);

            } catch (\Throwable $th) {
                return new JsonResponse(['code'=> 500 ,'info' => $th->getMessage()], 500);
            }
        }

        return $this->render('pro/add-guide-price.html.twig');
       
    }

    /**
    * @Route("/talk-us", name="pro_talk_us")
    */
    public function talkUs()
    {
        return $this->render('pro/talk-us.html.twig');
        
    }

    public function countDevis(Security $security, ServicesRepository $serviceRep, DevisRepository $devisRep): ?int
    {
        $services = $serviceRep->findByUser($security->getUser());
        $array = Array();
        foreach ($services as $key => $value) {
        $array[] = $value->getCategoryId();
        }
        $categoryId =  $array;
        $arrayData1 = array( 1=>  ($categoryId), 
            2=> $security->getUser()->getZipCode(), 
            3=> $security->getUser()->getUserCity(),
            4=>  ($categoryId)
            );

        $devis = $devisRep->findByZipCodeAndCity($arrayData1);
       
        return count($devis);
    }

}
