<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Article;
use App\Entity\Devis;
use App\Entity\Category;
use App\Entity\Type;
use App\Entity\Comments;
use App\Entity\Evaluations;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;
use App\Repository\FonctionRepository;
use App\Repository\PostRepository;
use App\Repository\CitiesRepository;
use App\Repository\ServicesRepository;
use App\Repository\CustomerRepository;
use App\Repository\AbonnementRepository;
use App\Repository\DevisRepository;
use App\Repository\DevisAcceptRepository;
use App\Repository\DevisValidRepository;
use App\Repository\DevisFinishRepository;
use App\Repository\ReponsePostAdsRepository;
use App\Repository\EvaluationsRepository;
use App\Repository\CommentsRepository;
use App\Repository\ConfigsiteRepository;
use App\Repository\EmojiRepository;
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
    public function dashbord(Security $security, ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CategoryRepository $categoryRep, UserRepository $userRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        
        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        //$post = $postRep->findByUser(array(1=> $security->getUser()));
        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        
        //BEGIN GET TOP DEVIS MORE ASKED
        $popularDevis = $artRep->findPopularDevisMoreAsk(array(1=> true));
        $popularDevis = count($popularDevis) > 0 ? $popularDevis : [];

        if (count($popularDevis) <= 0) {

                $popularDevis = array();
                $devisPopulars = $devisRep->findTopPopularDevis();
                $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;

                if($devisPopulars !== null) {

                    foreach ($devisPopulars as $key => $value) {
                    $popularDevis[] =  $artRep->findById($value['article_id']);
                    }

                }

        }
            //dump($popularDevis);die;
            //END GET POPULA DEVIS

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/dashbord.html.twig', [
            'pros' => $pros,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/list-articles-ajax", name="particulier_list_articles_ajax")
    */
    public function listArticlesAjax(Request $request, ConfigsiteRepository $configsiteRep, Security $security, CategoryRepository $categoryRep, ArticleRepository $articleRep)
    {

        try {
               // dump($request->query->get('categoryId'));die;
           
            $arrayArticles = $articleRep->findByCategory($categoryRep->findById($request->query->get('categoryId')));
            
            if(count($arrayArticles) == 0) {
                 
                return  new JsonResponse([array('info'=> false)], 200);
            }

            $arrayArticle = Array();
            foreach ($arrayArticles as $key => $value) {
                //dump($key . '  ' . $value->getCategTitle());die;
                $arrayArticle[] = [ 'value'=> $value->getId() , 'label'=> $value->getArticleTitle(), 'info'=> true ];
            }

            return  new JsonResponse($arrayArticle, 200);
            
        } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
        }  

    }
    

    /**
    * @Route("/lists-ask-projects-devis", name="particulier_ask_project_devis")
    */
    public function askProjectsDevis(Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
            
        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        $devis  = count($devis) ? $devis : null;
        //$post = $postRep->findByUser(array(1=> $security->getUser()));
        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/my-ask-devis-project-list.html.twig', [
            'devis' => $devis,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,

        ]);
    }

    /**
    * @Route("/lists-devis-receved-detail/{id}", name="particulier_devis_receved")
    */
    public function devisReceved($id = null, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, EvaluationsRepository $evalRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        $devis  = count($devis) ? $devis : null;
        //$post = $postRep->findByUser(array(1=> $security->getUser()));
        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $detailDevis = $devisRep->findById((int) $id);
        $listProsAcceptDevis = $devisAcceptRep->findByDevisId(array(1=> $detailDevis));
        $listProsAcceptDevis = count($listProsAcceptDevis) > 0 ? $listProsAcceptDevis : null;
        $nbDevisPros = array();
        $nbEvaluationPros = array();
        $partIsEvaluatePros = array();
       if($listProsAcceptDevis !== null) {
        foreach ($listProsAcceptDevis as $key => $value) {
            $nbDevisPros[$value->getUserId()->getId()] = count($devisAcceptRep->findByUserId(array(1=> $value->getUserId())));
            $nbEvaluationPros[$value->getUserId()->getId()] = count( $evalRep->findByUserId(array(1=> $value->getUserId())));
            $partEvaluatePros = $evalRep->findOneByUserProAndPart(array(1=> $value->getUserId(), 2=> $security->getUser()));
            $partIsEvaluatePros[$value->getUserId()->getId()] =  $partEvaluatePros !== null ? true : false;
            }
       }
       $nbDevisPros = count( $nbDevisPros) > 0 ? $nbDevisPros : null;
       $nbEvaluationPros = count( $nbEvaluationPros) > 0 ? $nbEvaluationPros : null;

       $categories = $categoryRep->findAllArray();
       $categories = count( $categories) > 0 ? $categories : null;
       //Get top devis more asked
       $devisPopulars = $devisRep->findTopPopularDevis();
       $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
       $popularDevis = array();
       if($devisPopulars !== null) {

           foreach ($devisPopulars as $key => $value) {
           $popularDevis[] =  $artRep->findById($value['article_id']);
           }
       }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/my-devis-receved-list.html.twig', [
            'devis'=> $devis,
            'detailDevis'=>  $detailDevis,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'listProsAcceptDevis'=> $listProsAcceptDevis,
            'nbDevisPros'=> $nbDevisPros,
            'nbEvaluationPros'=> $nbEvaluationPros,
            'partIsEvaluatePros'=> $partIsEvaluatePros,
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/post-ads-project", name="particulier_post_ads")
    */
    public function adsProjectPostule(Request $request, Security $security, ConfigsiteRepository $configsiteRep, AbonnementRepository $abonnementRep, CustomerRepository $customRep, ServicesRepository $serviceRep, UserRepository $userRep, ArticleRepository $artRep, CategoryRepository $categoryRep, TypeRepository $typeRep, CitiesRepository $cityRep, ArticleRepository $articleRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        //POST Record in database here
        if (!is_null($request->request->get('post_category')) && !is_null($request->request->get('post_nature')) && !is_null($request->request->get('post_type')) && !is_null($request->request->get('post_zipcode')) && !is_null($request->request->get('post_email')) && !is_null($request->request->get('post_phone')) && !is_null($request->request->get('post_description'))) {

            //dump($request->request->get('post_begin_project') . ' '. $request->request->get('post_category') . ' ' . $request->request->get('post_nature') . ' ' .$request->request->get('post_category') . ' ' . $request->request->get('post_type') . ' ' . $request->request->get('post_zipcode') . ' ' .$request->request->get('post_email') . ' ' . $request->request->get('post_phone'));die;
          
            try { 
                  
                //dump($request->request->get('city'));die;
                $post = new Post();
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->beginTransaction();
                $category = $categoryRep->findById((int) $request->request->get('post_category'));
                $post
                    ->setPostUserId($security->getUser())
                    ->setCategoryId($category)
                    ->setArticleId($articleRep->findById((int) $request->request->get('post_nature')))
                    ->setTypeId($typeRep->findById((int) $request->request->get('post_type')))
                    ->setPostAdsTravauxDescription($request->request->get('post_description'))
                    ->setPostZipcode($request->request->get('post_zipcode'))
                    ->setEmail($request->request->get('post_email'))
                    ->setPhone($request->request->get('post_phone'))
                    ->setCity($cityRep->findById((int) $request->request->get('city')))
                    ->setPostAdsStartDate($request->request->get('post_begin_project'))
                    ->setPostAdsDateCrea(new \DateTime('now'));

                if ($this->sendMail($post,  $category, $configsiteRep, $serviceRep, $customRep, $abonnementRep)) {

                    //$entityManager->persist($post);
                    //$entityManager->flush();
                   
                }
                $entityManager->commit();

                return new JsonResponse(array('code'=> 200, 'info'=> 'Vous avez postulé un projet!'), 200);

            } 
            catch (\Exception $e) {
                return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
            }

        }

            $prosArray = $userRep->findNewsProfessionals(10, 0);
            $pros = count( $prosArray) > 0 ? $prosArray : null;
            $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
            //$post = $postRep->findByUser(array(1=> $security->getUser()));
            $nbMyProject = 0;
            $nbDevis = 0;
            $nbPost = 0;
            if (count($devis) > 0) {
                foreach ( $devis as $key => $value) {
                    $devisArray[] = $value;
                } 
                $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
                $nbDevis = count($devis);
                $nbPost = $this->countAds($security, $postRep);
            }

            $categories = $categoryRep->findAllArray();
            $types = $typeRep->findAllArray();

           // $categories = $categoryRep->findAllArray();
            $categories = count( $categories) > 0 ? $categories : null;
            //Get top devis more asked
            $devisPopulars = $devisRep->findTopPopularDevis();
            $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
            $popularDevis = array();
            if($devisPopulars !== null) {

                foreach ($devisPopulars as $key => $value) {
                $popularDevis[] =  $artRep->findById($value['article_id']);
                }
            }

            //Get config site
            $configsite = $configsiteRep->findOneByIsActive();

            return $this->render('part/post-ads.html.twig', [
                'pros' => $pros,
                'nbMyProject'=> $nbMyProject,
                'nbDevis'=> $nbDevis,
                'nbPost'=> $nbPost,
                'nbPros'=> count($pros),
                'user'=> $security->getUser(),
                'categories'=> $categories,
                'types'=> $types,
                'popularDevis'=> $popularDevis,
                'configsite'=> $configsite,
            ]);      

    }

    /**
    * @Route("/lists-ads-postule", name="particulier_ads_postule")
    */
    public function listsAdsPostule(Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, ReponsePostAdsRepository $reponseRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        $devis  = count($devis) ? $devis : null;
        //$post = $postRep->findByUser(array(1=> $security->getUser()));
        $posts = $postRep->findByUser(array(1=> $security->getUser()));
        foreach ($posts as $key => $value) {
            $nbResponsePosts[$value->getId()] = count($reponseRep->findByUserIdAndPostId(array(1=> $security->getUser(), 2=> $value)));
        }
        
        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();


        return $this->render('part/my-project-postule-list.html.twig', [
            'posts' => $posts,
            'nbResponsePosts'=> $nbResponsePosts,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/lists-details-candidates/{id}", name="particulier_details_candidates")
    */
    public function listNumberDetailCandidate($id = null, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, ReponsePostAdsRepository $reponseRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, EvaluationsRepository $evalRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        $devis  = count($devis) ? $devis : null;
        //$post = $postRep->findByUser(array(1=> $security->getUser()));
        $detailPost = $postRep->findById((int) $id);
        $listResponsePosts = $reponseRep->findByUserIdAndPostId(array(1=> $security->getUser(), 2=> $detailPost));
        $listResponsePosts = count($listResponsePosts) > 0 ? $listResponsePosts : null;

        $nbEvaluationPros = array();
        $partIsEvaluatePros = array();
        if($listResponsePosts !== null) {
            foreach ($listResponsePosts as $key => $value) {
                $nbDevisPros[$value->getUserProId()->getId()] = count($devisAcceptRep->findByUserId(array(1=> $value->getUserProId())));
                $nbEvaluationPros[$value->getUserProId()->getId()] = count( $evalRep->findByUserId(array(1=> $value->getUserProId())));
                $partEvaluatePros = $evalRep->findOneByUserProAndPart(array(1=> $value->getUserProId(), 2=> $security->getUser()));
                $partIsEvaluatePros[$value->getUserProId()->getId()] =  $partEvaluatePros !== null ? true : false;
                }
        }

        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/number-detail-candidature-project.html.twig', [
            'detailPost' => $detailPost,
            'listResponsePosts'=> $listResponsePosts,
            'nbResponsePosts'=> count($listResponsePosts),
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'nbDevisPros'=> $nbDevisPros,
            'nbEvaluationPros'=> $nbEvaluationPros,
            'partIsEvaluatePros'=> $partIsEvaluatePros,
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/post-evaluations", name="particulier_post_evaluations")
    */
    public function evaluations(Request $request, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        
        if (!is_null($request->request->get('user_pros_id')) && !is_null($request->request->get('message_emoji')) && !is_null($request->request->get('star_emoji'))) {
           
            try {
                $evaluate = new Evaluations();
                $em = $this->getDoctrine()->getManager();
                $em->beginTransaction();
                $user = $userRep->findOneById((int) $request->request->get('user_pros_id'));
                $evaluate
                    ->setUserProId($user)
                    ->setUserPartId($security->getUser())
                    ->setMotif($request->request->get('message_emoji'))
                    ->setHaveStart($request->request->get('star_emoji'))
                    ->setDateCrea(new \DateTime('now'));
                    $em->persist($evaluate);
                    $em->flush();
                $em->commit();

                return new JsonResponse(['code'=>200, 'info'=> 'Vous avez évalué ce professionel!'], 200);
            } catch (\Throwable $th) {
                return new JsonResponse(['code'=>500, 'info'=> $th->getMessage()], 500);
            }

            $categories = $categoryRep->findAllArray();
            $categories = count( $categories) > 0 ? $categories : null;
            //Get top devis more asked
            $devisPopulars = $devisRep->findTopPopularDevis();
            $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
            $popularDevis = array();
            if($devisPopulars !== null) {

                foreach ($devisPopulars as $key => $value) {
                $popularDevis[] =  $artRep->findById($value['article_id']);
                }
            }

            //Get config site
            $configsite = $configsiteRep->findOneByIsActive();

            return $this->render('part/post-evaluations.html.twig', [
                'user'=> $security->getUser(),
                'categories'=> $categories,
                'popularDevis'=> $popularDevis,
                'configsite'=> $configsite,
            ]);

        }

    }

    /**
    * @Route("/projects-valid-finish", name="particulier_projects_valid_finish")
    */
    public function validFinishProjects(Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, ReponsePostAdsRepository $reponseRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        
        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        $devis  = count($devis) ? $devis : null;
        //$post = $postRep->findByUser(array(1=> $security->getUser()));    
        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $devisAccepts = $this->listDevisAccept($security, $devis, $devisAcceptRep);
        $devisAccepts = count($devisAccepts) > 0 ? $devisAccepts : null;
        $devisValids = $this->listDevisVailid($security, $devisAccepts, $devisValidRep);
        $devisValids = count($devisValids) > 0 ?  $devisValids : null;
        $devisFinish = $this->listDevisFinish($security, $devisAccepts, $devisValidRep, $devisFinishRep);
        $devisFinish = count($devisFinish) > 0 ?  $devisFinish : null;

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/projects-valid-finish.html.twig', [
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'nbDevisAccept'=> count($devisAccepts),
            'nbDevisValid'=> count($devisValids),
            'nbDevisFinish'=> count( $devisFinish),
            'devisAccepts'=> $devisAccepts,
            'devisValids'=>  $devisValids,
            'devisFinish'=> $devisFinish,
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/projects-detail-accept/{id}", name="particulier_projects_detail_accept")
    */
    public function acceptProjectsDetails($id = null, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, EvaluationsRepository $evalRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $prosArray = $userRep->findNewsProfessionals(10, 0);
            $pros = count( $prosArray) > 0 ? $prosArray : null;
            $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
            $devis  = count($devis) ? $devis : null;
            //$post = $postRep->findByUser(array(1=> $security->getUser()));
            $nbMyProject = 0;
            $nbDevis = 0;
            $nbPost = 0;
            if (count($devis) > 0) {
                foreach ( $devis as $key => $value) {
                    $devisArray[] = $value;
                } 
                $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
                $nbDevis = count($devis);
                $nbPost = $this->countAds($security, $postRep);
            }

            $detailDevis = $devisRep->findById((int) $id);
            $listProsAcceptDevis = $devisAcceptRep->findByDevisId(array(1=> $detailDevis));
            $listProsAcceptDevis = count($listProsAcceptDevis) > 0 ? $listProsAcceptDevis : null;
            $nbDevisPros = array();
            $nbEvaluationPros = array();
            $partIsEvaluatePros = array();
        if($listProsAcceptDevis !== null) {
            foreach ($listProsAcceptDevis as $key => $value) {
                $nbDevisPros[$value->getUserId()->getId()] = count($devisAcceptRep->findByUserId(array(1=> $value->getUserId())));
                $nbEvaluationPros[$value->getUserId()->getId()] = count( $evalRep->findByUserId(array(1=> $value->getUserId())));
                $partEvaluatePros = $evalRep->findOneByUserProAndPart(array(1=> $value->getUserId(), 2=> $security->getUser()));
                $partIsEvaluatePros[$value->getUserId()->getId()] =  $partEvaluatePros !== null ? true : false;
                }
        }
        $nbDevisPros = count( $nbDevisPros) > 0 ? $nbDevisPros : null;
        $nbEvaluationPros = count( $nbEvaluationPros) > 0 ? $nbEvaluationPros : null;

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/detail-valid-finish.html.twig', [
            'devis'=> $devis,
            'detailDevis'=>  $detailDevis,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'listProsAcceptDevis'=> $listProsAcceptDevis,
            'nbDevisPros'=> $nbDevisPros,
            'nbEvaluationPros'=> $nbEvaluationPros,
            'partIsEvaluatePros'=> $partIsEvaluatePros,
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/projects-detail-valid/{id}", name="particulier_projects_detail_valid")
    */
    public function validProjectsDetails($id = null, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, EvaluationsRepository $evalRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $prosArray = $userRep->findNewsProfessionals(10, 0);
            $pros = count( $prosArray) > 0 ? $prosArray : null;
            $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
            $devis  = count($devis) ? $devis : null;
            //$post = $postRep->findByUser(array(1=> $security->getUser()));
            $nbMyProject = 0;
            $nbDevis = 0;
            $nbPost = 0;
            if (count($devis) > 0) {
                foreach ( $devis as $key => $value) {
                    $devisArray[] = $value;
                } 
                $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
                $nbDevis = count($devis);
                $nbPost = $this->countAds($security, $postRep);
            }

            $detailDevis = $devisValidRep->findByDevisAcceptId((int) $id);
            
            $detailDev = $devisRep->findById($devisAcceptRep->findById($detailDevis->getDevisAcceptId()->getId())->getDevisId()->getId());
            $listProsAcceptDevis = $devisAcceptRep->findById($detailDevis->getDevisAcceptId()->getId());
            $listProsValideDevis[0] = !is_null($listProsAcceptDevis) ? $listProsAcceptDevis : null;
            
            $nbDevisPros = array();
            $nbEvaluationPros = array();
            $partIsEvaluatePros = array();
        if($detailDevis !== null) {
           
                $nbDevisPros[$detailDevis->getUserId()->getId()] = count($devisAcceptRep->findByUserId(array(1=> $detailDevis->getUserId())));
                $nbEvaluationPros[$detailDevis->getUserId()->getId()] = count( $evalRep->findByUserId(array(1=> $detailDevis->getUserId())));
                $partEvaluatePros = $evalRep->findOneByUserProAndPart(array(1=> $detailDevis->getUserId(), 2=> $security->getUser()));
                $partIsEvaluatePros[$detailDevis->getUserId()->getId()] =  $partEvaluatePros !== null ? true : false;
               
        }
        $nbDevisPros = count( $nbDevisPros) > 0 ? $nbDevisPros : null;
        $nbEvaluationPros = count( $nbEvaluationPros) > 0 ? $nbEvaluationPros : null;

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/detail-valid-finish.html.twig', [
            'devis'=> $devis,
            'detailDevis'=>  $detailDev,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'listProsAcceptDevis'=> $listProsValideDevis,
            'nbDevisPros'=> $nbDevisPros,
            'nbEvaluationPros'=> $nbEvaluationPros,
            'partIsEvaluatePros'=> $partIsEvaluatePros,
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/projects-detail-finish/{id}", name="particulier_projects_detail_finish")
    */
    public function finishProjectsDetails($id = null, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep, DevisFinishRepository $devisFinishRep, EvaluationsRepository $evalRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $prosArray = $userRep->findNewsProfessionals(10, 0);
            $pros = count( $prosArray) > 0 ? $prosArray : null;
            $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
            $devis  = count($devis) ? $devis : null;
            //$post = $postRep->findByUser(array(1=> $security->getUser()));
            $nbMyProject = 0;
            $nbDevis = 0;
            $nbPost = 0;
            if (count($devis) > 0) {
                foreach ( $devis as $key => $value) {
                    $devisArray[] = $value;
                } 
                $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
                $nbDevis = count($devis);
                $nbPost = $this->countAds($security, $postRep);
            }

            $detailDevis = $devisFinishRep->findByDevisValidId((int) $id);
            
            $detailDev = $devisRep->findById($devisAcceptRep->findById($devisValidRep->findById($detailDevis->getDevisValid()->getId())->getDevisAcceptId()->getId())->getDevisId()->getId());
            $listProsAcceptDevis = $devisAcceptRep->findById($devisValidRep->findById($detailDevis->getDevisValid()->getId())->getDevisAcceptId()->getId());
            $listProsValideDevis[0] = !is_null($listProsAcceptDevis) ? $listProsAcceptDevis : null;
            
            $nbDevisPros = array();
            $nbEvaluationPros = array();
            $partIsEvaluatePros = array();
        if($detailDevis !== null) {
           
                $nbDevisPros[$detailDevis->getUserId()->getId()] = count($devisAcceptRep->findByUserId(array(1=> $detailDevis->getUserId())));
                $nbEvaluationPros[$detailDevis->getUserId()->getId()] = count( $evalRep->findByUserId(array(1=> $detailDevis->getUserId())));
                $partEvaluatePros = $evalRep->findOneByUserProAndPart(array(1=> $detailDevis->getUserId(), 2=> $security->getUser()));
                $partIsEvaluatePros[$detailDevis->getUserId()->getId()] =  $partEvaluatePros !== null ? true : false;
               
        }
        $nbDevisPros = count( $nbDevisPros) > 0 ? $nbDevisPros : null;
        $nbEvaluationPros = count( $nbEvaluationPros) > 0 ? $nbEvaluationPros : null;

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/detail-valid-finish.html.twig', [
            'devis'=> $devis,
            'detailDevis'=>  $detailDev,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'listProsAcceptDevis'=> $listProsValideDevis,
            'nbDevisPros'=> $nbDevisPros,
            'nbEvaluationPros'=> $nbEvaluationPros,
            'partIsEvaluatePros'=> $partIsEvaluatePros,
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/part-password-edit", name="particulier_password_edit")
    */
    public function editPassword(Request $request, ConfigsiteRepository $configsiteRep, UserPasswordEncoderInterface $passwordEncoder, Security $security, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_USER_PARTICULAR', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

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

        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        //$post = $postRep->findByUser(array(1=> $security->getUser()));
        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/password-edit.html.twig', [
            'pros' => $pros,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);
    }

    /**
    * @Route("/edit-profil", name="particulier_edit_profil")
    */
    public function editProfil(Request $request, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $user, CategoryRepository $categoryRep, ArticleRepository $artRep)
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
    * @Route("/post-comments-particular", name="particulier_post_comments")
    */
    public function postComments(Request $request, Security $security, ConfigsiteRepository $configsiteRep, UserRepository $userRep, CategoryRepository $categoryRep, ArticleRepository $artRep, DevisRepository $devisRep, PostRepository $postRep, DevisAcceptRepository $devisAcceptRep, DevisValidRepository $devisValidRep)
    {
         if(!is_null($request->request->get('comment_description'))) {
                   
                try {   
                   
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->beginTransaction();
                    $comment = new Comments();
                    $comment
                        ->setDescription($request->request->get('comment_description'))
                        ->setIsParticular(true)
                        ->setUserId($security->getUser())
                        ->setDatecrea(new \DateTime('now'));
                    $entityManager->persist($comment);
                    $entityManager->flush();
                    $entityManager->commit();

                    return new JsonResponse(array('code'=> 200, 'info'=>  'Vous avez misé(e) un commentaire!'), 200);

                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
                }
        }
       
        $prosArray = $userRep->findNewsProfessionals(10, 0);
        $pros = count( $prosArray) > 0 ? $prosArray : null;
        $devis = $devisRep->findByEmail(array(1=> $security->getUser()->getEmail()));
        //$post = $postRep->findByUser(array(1=> $security->getUser()));
        $nbMyProject = 0;
        $nbDevis = 0;
        $nbPost = 0;
        if (count($devis) > 0) {
            foreach ( $devis as $key => $value) {
                $devisArray[] = $value;
            } 
            $nbMyProject = $this->countDevisVailid($security, $devisAcceptRep->findByDevisIdList(array(1=> $devisArray)), $devisValidRep);
            $nbDevis = count($devis);
            $nbPost = $this->countAds($security, $postRep);
        }

        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
            $popularDevis[] =  $artRep->findById($value['article_id']);
            }
        }

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('part/add-comment-particular.html.twig', [
            'pros' => $pros,
            'nbMyProject'=> $nbMyProject,
            'nbDevis'=> $nbDevis,
            'nbPost'=> $nbPost,
            'nbPros'=> count($pros),
            'user'=> $security->getUser(),
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
        ]);

    }

    //Function to send mail to each professional
    public function sendMail($post = null, $category  =null, $configsiteRep, ServicesRepository $serviceRep, CustomerRepository $customRep, AbonnementRepository $abonnementRep)
    {

        $myservices = $serviceRep->findByCategoryId($category);

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();
        //dump($myservices);die;
        if(count($myservices) > 0) {

            foreach ($myservices as $key => $myservice) {
                $customer = $customRep->findByUser($myservice->getUserId());
                $arrayCriticals = array(1=>  $customer, 2=> $myservice); // prepare query to get abonnement here!
                if ($customer !== null && $myservice->getIsActived() == true && $abonnementRep->isPremiumAndDateExpireValid($arrayCriticals) == true) 
                {
                    // $devis = $devisRep->findById(6);

                        $transport = new \Swift_SmtpTransport();
                            $transport
                            ->setHost('smtp.gmail.com')
                            ->setEncryption('ssl')
                            ->setPort(465)  
                            ->setAuthMode('login')
                            ->setUsername($configsite->getEmail())
                            ->setPassword('bnzkglnpuhzlxlgp');
            
                        // // Create the Mailer using your created Transport
                        $mailer = new \Swift_Mailer($transport);

                        $mailer->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );

                        $message = (new \Swift_Message('OFFRE DE NOUVEAU CHANTIER'))
                        ->setFrom($configsite->getEmail())
                        ->setTo($myservice->getUserId()->getEmail());
                        // ->setBody('<p>Merci mon Dieu!!</p>', 'text/html', 'utf-8');
     
                        $img = $message->embed(\Swift_Image::fromPath('assets/img/logo.png'));

                        $message->setBody(
                            $this->renderView(
                                // templates/emails/registration.html.twig
                                'premuim/send-email-ads.html.twig',
                                ['post' => $post, 'img' => $img, 'isAbonned'=> false, 'isMail'=> true]
                            ),
                            'text/html'
                        );

                    $result =  $mailer->send($message);  //die('stop');
                   
                    //dump($result);die;

                }
            }
            return true;

        }//END IF TEST SERVICE COUNT HERE

        return true;

    }


    //function to get list accept, valid, finish of the devis
    public function countDevis($security = null, $devisRep = null) : ?int
    {
        
        return count($devisRep->findByEmail(array(1=> $security->getUser()->getEmail())));
    }

    public function countAds(Security $security = null, $postRep = null) : ?int
    {
       
        return count($postRep->findByUser(array(1=> $security->getUser())));
    }

    public function countDevisAccept($security = null, $devis = null, $devisAcceptRep = null) : ?int
    {
        foreach ($devis as $key => $value) {
            $devisArray[] = $value;
        }
        return count($devisAcceptRep->findByDeviIdList(array(1=> $devisArray)));
    }

    public function countDevisVailid($security = null, $devisAccepts = null, $devisValidRep = null) : ?int
    {
        foreach ($devisAccepts as $key => $value) {
            $devisAcceptArray[] = $value;
        }
        return count($devisValidRep->findByDevisAcceptIdList(array(1=> $devisAcceptArray)));
    }

    public function countDevisFinish($security = null, $devisAccepts = null, $devisValidRep = null, $devisFinishRep = null) : ?int
    {
        foreach ($devisAccepts as $key => $value) {
            $devisAcceptArray[] = $value;
        }

        $devisvalids = $devisValidRep->findByDevisAcceptIdList(array(1=> $devisAcceptArray));
        foreach ($devisvalids as $key => $value) {
            $devisArray[] = $value;
        }
        return count($devisFinishRep->findByDevisValidIdList(array(1=> $devisValidArray)));
    }


    //List begin here
    public function listDevisAccept($security = null, $devis = null, $devisAcceptRep = null) : ?array
    {
        foreach ($devis as $key => $value) {
            $devisArray[] = $value;
        }
        return $devisAcceptRep->findByDevisIdList(array(1=> $devisArray));
    }

    public function listDevisVailid($security = null, $devisAccepts = null, $devisValidRep = null) : ?array
    {
        foreach ($devisAccepts as $key => $value) {
            $devisAcceptArray[] = $value;
        }
        return $devisValidRep->findByDevisAcceptIdList(array(1=> $devisAcceptArray));
    }

    public function listDevisFinish($security = null, $devisAccepts = null, $devisValidRep = null, $devisFinishRep = null) : ?array
    {
        foreach ($devisAccepts as $key => $value) {
            $devisAcceptArray[] = $value;
        }

        $devisvalids = $devisValidRep->findByDevisAcceptIdList(array(1=> $devisAcceptArray));
        foreach ($devisvalids as $key => $value) {
            $devisArray[] = $value;
        }
        return $devisFinishRep->findByDevisValidIdList(array(1=> $devisArray));
    }


}