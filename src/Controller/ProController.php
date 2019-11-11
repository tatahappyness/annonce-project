<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Devis;
use App\Entity\Customer;
use App\Entity\Comments;
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
use App\Repository\VideosRepository;
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
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
        $postsAds = count( $postsAdsArray ) !== 0 ? $postsAdsArray : [null];

        //Get DISTANCE AND CALCULATE BY KM USING LAT AND LONG
        foreach ($postsAds as $key => $post) {

            $cityArray1['lat'] = $post->getCity()->getVilleLatitudeDeg();
            $cityArray1['lng'] = $post->getCity()->getVilleLongitudeDeg();
            $cityArray2['lat'] =  ($security->getUser()->getLat() !== null) ? $security->getUser()->getLat() : $security->getUser()->getUserCity()->getVilleLatitudeDeg();
            $cityArray2['lng'] = ($security->getUser()->getLog() !== null) ? $security->getUser()->getLog() : $security->getUser()->getUserCity()->getVilleLongitudeDeg();

            $distances[$post->getId()] =  $this->getDistance($cityArray1, $cityArray2, 'Km');

        }
        
        //dump($distances);die;

        return $this->render('pro/dashbord.html.twig', [
            'numberDevis' => $nbdevis,
            'distances'=> $distances,
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
        $postsAds = count( $postsAdsArray ) > 0 ? $postsAdsArray : null;
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

        //Get DISTANCE AND CALCULATE BY KM USING LAT AND LONG
        foreach ($postsAds as $key => $post) {

            $cityArray1['lat'] = $post->getCity()->getVilleLatitudeDeg();
            $cityArray1['lng'] = $post->getCity()->getVilleLongitudeDeg();
            $cityArray2['lat'] =  ($security->getUser()->getLat() !== null) ? $security->getUser()->getLat() : $security->getUser()->getUserCity()->getVilleLatitudeDeg();
            $cityArray2['lng'] = ($security->getUser()->getLog() !== null) ? $security->getUser()->getLog() : $security->getUser()->getUserCity()->getVilleLongitudeDeg();

            $distances[$post->getId()] =  $this->getDistance($cityArray1, $cityArray2, 'Km');

        }
        
        //dump($distances);die;
       
        return $this->render('pro/projects-dispos.html.twig', [
            'postAds' => $postsAds, 
            'distances'=> $distances,
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'user'=> $security->getUser(),
        ]);

    }

    /**
    * @Route("/get-lat-log-ajax", name="pro_lat_log")
    */
    public function geolocation(Security $security)
    {
        $LocationArray = ['lat'=> $security->getUser()->getLat(), 'log'=> $security->getUser()->getLog()];

        return new JsonResponse($LocationArray, 200);

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
            'service'=> $myservice,
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
    public function proEvaluations(Security $security, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep, EvaluationsRepository $evaluationRep, ImagesRepository $imageRep, CustomerRepository $customRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $devisAcceptArray = $devisAcceptRep->findByUserId($security->getUser());
        $devisValidArray = $devisValidRep->findByUserId($security->getUser());
        $devisFinishArray = $devisFinishRep->findByUserId($security->getUser());

        $devisAccept = count( $devisAcceptArray) > 0 ?  $devisAcceptArray : null;
        $devisValid = count( $devisValidArray) > 0 ?  $devisValidArray : null;
        $devisFinish = count( $devisFinishArray) > 0 ?  $devisFinishArray : null;

        //get Evaluations
        $evaluation = $evaluationRep->findByUserId(array(1=> $security->getUser()));
        $evaluations = count($evaluation) > 0 ? $evaluation : null;

        return $this->render('pro/pro-evaluations.html.twig', [
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'devisAccept'=> $devisAccept,
            'devisValid'=> $devisValid,
            'devisFinish'=> $devisFinish,
            'user'=> $security->getUser(),
            'evaluations'=> $evaluations,
        ]);
    }

    /**
    * @Route("/show-my-profil", name="pro_show_profil")
    */
    public function profil(Security $security, VideosRepository $videoRep, DocummentRepository $docummentRep, LabelsRepository $labelRep, EvaluationsRepository $evaluationRep, ImagesRepository $imageRep, CustomerRepository $customRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep)
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
        $document = $docummentRep->findByUserId(array(1=> $security->getUser()));
        $documents = count($document) > 0 ? $document : null;
       //get Labels Quality
        $label = $labelRep->findByUserId(array(1=> $security->getUser())); 
        $labels = count($label) > 0 ? $label : null;
        //get image realize
        $image = $imageRep->findByUserId(array(1=> $security->getUser()));
        $images = count($image) > 0 ? $image : null;

        //get Videos realize
        $videos = $videoRep->findByUserId(array(1=> $security->getUser()));
        $videos = count($videos) > 0 ? $videos : [];

        return $this->render('pro/profil.html.twig', [
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'postAds'=> $postsAds,
            'nbProjectDispo'=> count($postsAds),
            'user'=> $security->getUser(),
            'documents'=> $documents,
            'images'=> $images,
            'labels'=> $labels,
            'videos'=>  $videos,
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

                    return new JsonResponse(array('code'=> 200, 'info'=>  'Chargement de profil effectué1;'), 200);

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
    * @Route("/edit-logo", name="pro_edit_logo")
    */
    public function editLogo(Request $request, Security $security, CustomerRepository $customRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if (!is_null($request->files->get('file-upload')) ) {

            $file = $request->files->get('file-upload');
            
            $output_dir = $this->getParameter('logo_directory');
            $arr_extensions = ["jpeg", "jpg", "png"];
            //@Assert\File(maxSize="6000000")

            if (!(in_array($file->getClientOriginalExtension(), $arr_extensions))) 
            {
                return new JsonResponse(array('code'=> 401, 'info'=> 'Type de fichier n\'est pas autorisé'), 401);
            }
               
            try { 
                // generate a random name for the file but keep the extension
                $filename = uniqid().".".$file->getClientOriginalExtension();
                $file->move( $output_dir, $filename); // move the file to a path

                $user = $security->getUser();
                $user
                    ->setLogo($filename);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->merge($user);
                $entityManager->flush();

                return new JsonResponse(array('code'=> 200, 'info'=>   $filename), 200);

            } 
            catch (\Exception $e) {
                return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
            }
        }
        return new JsonResponse(['code'=> 500, "info" => 'Vous avez fait une movaise requête!'], 500);        

      
    }

    /**
    * @Route("/company-edit", name="pro_company_edit")
    */
    public function editCompany(Request $request, Security $security, CitiesRepository $cityRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {

        if($_POST) {
           
            if (!is_null($request->request->get('company_caracter')) && !is_null($request->request->get('company_datecrea')) && !is_null($request->request->get('company_description')) ) {

                $user = $security->getUser();
                $user
                    ->setCompanyCarater($request->request->get('company_caracter'))
                    ->setCompanyDateCrea($request->request->get('company_datecrea'))
                    ->setCompanyDescription($request->request->get('company_description'));
                    
                    $entityManager = $this->getDoctrine()->getManager();

                try {
    
                    $entityManager->merge($user);
                    $entityManager->flush();
                    return new JsonResponse(['code'=> 200, "infos" => 'Enregistrement effectuée!'], 200);
                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'infos' => $e->getMessage()], 500);
                }                
            
            }

        }
        
        return new Response('Cettes page n\'est pas autorisé!');
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
    public function editGeolocationMap(Request $request, Security $security, CitiesRepository $cityRep, DevisRepository $devisRep, PostRepository $postRep, ServicesRepository $serviceRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if($_POST){

            $lat = $request->request->get('latitude');
            $long = $request->request->get('longitude');
            //dump( $url . ' ' . $articleId); 
            if($lat !== null &&   $long!== null) {	
                //dump($request->getMethod());die;
                //dump( $articleId . ' ' . $url);die;

                try {

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->beginTransaction();

                    $user = $security->getUser();
                    $user
                        ->setLat($lat)
                        ->setLog($long);

                    $entityManager->persist($user);
                    $entityManager->flush();
                    $entityManager->commit();
                
                    // return new JsonResponse(array('code'=> 200, 'infos'=> 'Enrégistrement effectué!'), 200);
                    return $this->redirectToRoute('pro_dashbord');

                    } catch (\Throwable $th) {
                        return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
                    }
            }            

        } // END POST GEO

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

        return $this->render('pro/my-geolocation-map-edit.html.twig', [
            'user'=> $security->getUser(),
            'numberDevis' => $nbdevis,
            'nbProjectDispo'=> count($postsAds),
        ]);
    }

    /**
    * @Route("/password-edit", name="pro_password_edit")
    */
    public function editpassword(Request $request, Security $security, UserPasswordEncoderInterface $passwordEncoder, ServicesRepository $serviceRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if($_POST) {

            //dump($request->request->get('passwd_new'));die;
            if (!is_null($request->request->get('passwd_old')) && !is_null($request->request->get('passwd_new')) && $request->request->get('passwd_new') !== '' && !is_null($request->request->get('passwd_comfirm')) ) {
               
                $user = $security->getUser();
                $user
                    ->setPassword($passwordEncoder->encodePassword(
                        $user,
                        $request->request->get('passwd_new')
                    ));
                $entityManager = $this->getDoctrine()->getManager();
                try {
        
                    $entityManager->merge($user);
                    $entityManager->flush();
                    return new JsonResponse(['code'=> 200, "info" => 'Vous avez changé votre mot de passe!'], 200);
                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
                }
            }
            return new JsonResponse(['code'=> 400, "info" => 'Vous avez fait une movaise requête!'], 400);


        }

        $devisAcceptArray = $devisAcceptRep->findByUserId($security->getUser());
        $devisValidArray = $devisValidRep->findByUserId($security->getUser());
        $devisFinishArray = $devisFinishRep->findByUserId($security->getUser());

        $devisAccept = count( $devisAcceptArray) > 0 ?  $devisAcceptArray : null;
        $devisValid = count( $devisValidArray) > 0 ?  $devisValidArray : null;
        $devisFinish = count( $devisFinishArray) > 0 ?  $devisFinishArray : null;

        return $this->render('pro/my-password-edit.html.twig', [
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'devisAccept'=> $devisAccept,
            'devisValid'=> $devisValid,
            'devisFinish'=> $devisFinish,
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
                    ->setName($filename)
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
        $articles = count($articles) > 0 ? $articles : null;

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
    public function editVideosRealize(Request $request, Security $security, PostRepository $postRep, ServicesRepository $serviceRep, ArticleRepository $articleRep, CustomerRepository $customRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        //var_dump($request->request->all()); //if you need to know if the file is being uploaded.
       
        if($_POST) {
           
           $url = $request->request->get('url_video');
            $articleId = $request->request->get('article_id');
            //dump( $url . ' ' . $articleId); 
            if($articleId !== null &&   $url!== null) {	
                //dump($request->getMethod());die;
                //dump( $articleId . ' ' . $url);die;

                try {

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->beginTransaction();

                    $video = new Videos();
                    $video
                        ->setArticleTitle($articleRep->findById((int) $articleId))
                        ->setUserId($security->getUser())
                        ->setName($url)
                        ->setDateCrea(new \DateTime('now'));

                        $entityManager->persist($video);
                        $entityManager->flush();
                        $entityManager->commit();
                
                    // return new JsonResponse(array('code'=> 200, 'infos'=> 'Enrégistrement effectué!'), 200);
                    return $this->redirectToRoute('pro_show_profil');

                    } catch (\Throwable $th) {
                        return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
                    }
            }

        } //END POST HERE

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
    
        //get article()
       $article = $articleRep->findByCategoryArray(array(1=> $categoryId));

        return $this->render('pro/video-chantie-realize-edit.html.twig', [
            'numberDevis' => $nbdevis,
            'postAds'=> $postsAds,
            'nbProjectDispo'=> count($postsAds),
            'user'=> $security->getUser(),
            'articles'=> $article,
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
        $offer = $offerRep->findByCategoryId($serviceRep->findById((int) $id)->getCategoryId());
        return $this->render('premuim/strip-form.html.twig', [
            'serviceId' => $id, 'offer'=> $offer
        ]);   
    }

    /**
    * @Route("/lists-services", name="pro_services")
    */
    public function services(Security $security, CategoryRepository $categoryRep, ServicesRepository $serviceRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
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
        //get category lists
        $categories = $categoryRep->findAllArray();
        $categories = count($categories) ? $categories : null;
        return $this->render('pro/services.html.twig', [
            'services' => $services,
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'devisAccept'=> $devisAccept,
            'devisValid'=> $devisValid,
            'devisFinish'=> $devisFinish,
            'user'=> $security->getUser(),
            'categories'=> $categories,
        ]);
    }

    /**
    * @Route("/add-service", name="pro_add_service")
    */
    public function addService(Request $request, Security $security, CategoryRepository $categoryRep)
    {
        if($_POST) {

            if( $request->request->get('category_id_pro') !== null ) {

               try {

                    $em =  $this->getDoctrine()->getManager();
                    $em->beginTransaction();
                    $service = new Services();
                    $service
                        ->setUserId($security->getUser())
                        ->setCategoryId($categoryRep->findById((int) $request->request->get('category_id_pro')))
                        ->setDateCrea(new \DateTime('now'));
                    $em->persist($service);
                    $em->flush();
                    $em->commit();
                    return new JsonResponse(['code'=> 200 ,'info' => 'Vous avez ajouté un nouveau service!'], 200);

                } catch (\Throwable $th) {
                    return new JsonResponse(['code'=> 500 ,'info' => $th->getMessage()], 500);
                }
            }
            
        }
        return new JsonResponse(['code'=> 500 ,'info' => 'Vous avez fait la movaise requête!'], 500);

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
    * @Route("/talk-us", name="pro_talk_us")
    */
    public function talkUs(Request $request, Security $security, ServicesRepository $serviceRep, DevisRepository $devisRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {

        if ($_POST) {
           
            if(!is_null($request->request->get('comment_description'))) {
                
                try {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->beginTransaction();
                    $comment = new Comments();
                    $comment
                        ->setDescription($request->request->get('comment_description'))
                        ->setIsPro(true)
                        ->setUserId($security->getUser())
                        ->setDatecrea(new \DateTime('now'));
                    $entityManager->persist($comment);
                    $entityManager->flush();
                    $entityManager->commit();
                    return new JsonResponse(['code'=> 200 ,'info' => 'Vous avez misé(e) un commentaire!'], 200);

                } catch (\Throwable $th) {
                    return new JsonResponse(['code'=> 500 ,'info' => $th->getMessage()], 500);
                }

            }

        }

        $devisAcceptArray = $devisAcceptRep->findByUserId($security->getUser());
        $devisValidArray = $devisValidRep->findByUserId($security->getUser());
        $devisFinishArray = $devisFinishRep->findByUserId($security->getUser());

        $devisAccept = count( $devisAcceptArray) > 0 ?  $devisAcceptArray : null;
        $devisValid = count( $devisValidArray) > 0 ?  $devisValidArray : null;
        $devisFinish = count( $devisFinishArray) > 0 ?  $devisFinishArray : null;
        
        return $this->render('pro/talk-us.html.twig', [
            'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),
            'devisAccept'=> $devisAccept,
            'devisValid'=> $devisValid,
            'devisFinish'=> $devisFinish,
            'user'=> $security->getUser(),
        ]);
        
    }

    /**
    * @Route("/download-file/{id}", name="pro_download_file")
    */
    public function downloadAction($id = null) {

        try {
            $displayName = $id;
            $file_with_path = $this->getParameter( 'documents_directory' ) . "/" . $id;
            $response = new BinaryFileResponse( $file_with_path );
            $response->headers->set( 'Content-Type', 'text/plain' );
            $response->setContentDisposition( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $displayName );
            return $response;

        } catch( Exception $e ) {
            $array = array (
                'status' => 0,
                'message' => 'Download error' 
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
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

    //GET DISTANCE BETWEEN TWO ZIP CODE OR LAT AND LONG
    // This function returns Longitude & Latitude from zip code.
    function getDistance($first_lat, $next_lat, $unit)
    {
        $lat1 = $first_lat['lat'];
        $lon1 = $first_lat['lng'];
        $lat2 = $next_lat['lat'];
        $lon2 = $next_lat['lng']; 
        $theta=$lon1-$lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K"){
            return ($miles * 1.609344)." ".$unit;
        }
        else if ($unit =="N"){
            return ($miles * 0.8684)." ".$unit;
        }
        else{
            return round($miles)." ".$unit;
        }

    } //End function get distance 


}
