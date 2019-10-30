<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Article;
use App\Entity\Devis;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;
use App\Repository\GuidePriceRepository;
use App\Repository\FonctionRepository;
use App\Repository\PostRepository;
use App\Repository\CitiesRepository;
use App\Repository\ServicesRepository;
use App\Repository\CustomerRepository;
use App\Repository\AbonnementRepository;
use App\Repository\DevisRepository;
use App\Repository\EmojiRepository;
use App\Repository\CommentsRepository;
use App\Repository\EvaluationsRepository;
use App\Repository\DocummentRepository;
use App\Repository\ImagesRepository;
use App\Repository\LabelsRepository;
use App\Repository\OfferRepository;
use App\Repository\SiteinternetRepository;
use App\Repository\VideosRepository;
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

class PageController extends AbstractController
{
    /**
    * @Route("/", name="home_page")
    */
    public function home( ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
        
       try {
           
        $arrayarticles = $artRep->findAll();
        $arraytypes = $typeRep->findAll();
        $categories = $categoryRep->findAllArray();
        $articles =  count($arrayarticles) > 0 ? $arrayarticles : null;
        $types = count($arraytypes) > 0 ? $arraytypes : null;
       $categories = count( $categories) > 0 ? $categories : null;
       //Get new pros list
        //array(1=> true, 2=> $activity, 3=> $city, 4=> $activity)
        $newPros = $userRep->findAllProfessionals();
        $newPros = count( $newPros) > 0 ? $newPros : null;
       //Get guides prices list

       //Get top devis more asked
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        $popularDevis = array();
        if($devisPopulars !== null) {

            foreach ($devisPopulars as $key => $value) {
               $popularDevis[] =  $artRep->findById($value['article_id']);
            }

        }
        //dump($popularDevis);die;
       //Get comments list by particulars
        $comments = $commentRep->findAllComments(6);
        $comments = count( $comments) > 0 ? $comments : null;
        //dump( $comments);die;
       } catch (\Throwable $th) {
        return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
       }
        return $this->render('page/home/accueil.html.twig', [
            'articles'=> $articles, 
            'types'=> $types,
           'popularDevis'=> $popularDevis,
           'categories'=> $categories,
           'newPros'=> $newPros,
           'comments'=> $comments,
           'guidesPrice'=> 1


        ]);
        
    }

    /**
    * @Route("/list-cagory-ajax", name="list_ategory_ajax")
    */
    public function listCagoryAjax( CategoryRepository $categRep )
    {
        
        try {
            
            $categories = $categRep->findAllArray();

        } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
        }   

            $arrayCats = Array();
            if (!is_null($categories)) {
                foreach ($categories as $key => $value) {
                    //dump($key . '  ' . $value->getCategTitle());die;
                    $arrayCats[] = ['value'=> $value->getId() , 'label'=> $value->getCategTitle() ];
                }
            }
            else{
                $arrayCats[] = ['value'=> '' , 'label'=> '' ];
            }

            // dump( $arrayCats); die;

            return  new JsonResponse($arrayCats, 200);
            
    }

    /**
    * @Route("/list-city-ajax", name="list_city_ajax")
    */
    public function listCityAjax( Request $request, CategoryRepository $categRep, CitiesRepository $cityRep )
    {


        try {
           
            $arrayCitys = $cityRep->findByZipCode($request->query->get('zipCode'));
            
            if(count($arrayCitys) == 0) {
                
                return  new JsonResponse(['info'=> false], 200);
            }

            $arrayCity = Array();
            foreach ($arrayCitys as $key => $value) {
                //dump($key . '  ' . $value->getCategTitle());die;
                $arrayCity[] = [ 'value'=> $value->getId() , 'label'=> $value->getVilleNomReel(), 'info'=> true ];
            }

            return  new JsonResponse($arrayCity, 200);
            
        } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
        }  
        
    }

    /**
    * @Route("/get-list-emojis", name="get_list_emojis_page")
    */
    public function getListEmojis(Security $security, EmojiRepository $emojiRep)
    {
        //$emojisArray = array();
        $emojis = $emojiRep->findAllArray();
        if (count($emojis) > 0) {
            foreach ($emojis as $key => $value) {    
                $emojisArray = str_replace("'", "", $value->getCode());
            $emojisArrayFilter = explode(',', $emojisArray);
            }
            //dump($emojisArrayFilter);die;
            return new JsonResponse(['code'=>200, 'emojis'=> $emojisArrayFilter], 200);
        }
    }

    /**
    * @Route("/inscription", name="inscription_page")
    */
    public function inscription(ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
      
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

       return $this->render('page/inscription.html.twig', [
           'categories'=> $categories,
           'devisPopulars'=> $devisPopulars,
           ]);
        
    }

    /**
    * @Route("/inscription-particulier", name="inscription_particulier_page")
    */
    public function inscriptionParticulier(ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
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

        return $this->render('page/inscription-particular.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/get-articles", name="get_articles_page")
    */
    public function articles()
    {
        return new JsonResponse(['code'=> 200], 200);
        
    }

    /**
    * @Route("/post-ask-devis/{id}/{prosId}", name="post_ask_devis_page", requirements={"id"="\d+"})
    */
    public function postAskDevis($id = null, $prosId = null, Request $request, GuidePriceRepository $guidePriceRep, CitiesRepository $cityRep, TypeRepository $typeRep, CategoryRepository $categRep, ArticleRepository $artRep, FonctionRepository $foncRep, ServicesRepository $serviceRep, CustomerRepository $customRep, AbonnementRepository $abonnementRep, \Swift_Mailer $mailer, UserRepository $userRep)
    {       
            // dump($_ENV['MAILER_URL']);die;
            
        $arrayTypes = $typeRep->findAllArray();
        $arrayArticles = $artRep->findAllArray();
        $articles =  !is_null($arrayArticles) ? $arrayArticles : null;
        $types = !is_null($arrayTypes) ? $arrayTypes : null;
        $arrayFonctions = $foncRep->findAllArray();
        $fonctions = !is_null($arrayFonctions) ? $arrayFonctions : null;

        if ($_POST) {
            // Posting Ask in Server data base
            if(!is_null($request->request->get('post_metier_ask_devis')) && !is_null($request->request->get('post_civility_ask_devis')) && !is_null($request->request->get('post_description_ask_devis')) && !is_null($request->request->get('post_email_ask_devis')) && !is_null($request->request->get('post_zipcode_ask_devis')) && !is_null($request->request->get('post_phone_ask_devis'))){
               
                $devis = new Devis();
                //dump($request->request->get('ask_devis_type'));die;
                $em = $this->getDoctrine()->getManager();
                $em->beginTransaction();

                if (!is_null($request->request->get('UserProsId'))) {
                   $userPros = $userRep->findOneById((int) $request->request->get('UserProsId'));
                   $devis->setDevUserIdDest($userPros);
                }

                $article = $artRep->findById((int) $request->request->get('post_metier_ask_devis'));
                $devis
                   ->setTypeProject($typeRep->findById((int) $request->request->get('ask_devis_type')))
                   ->setNatureProject($article)
                   ->setCategoryId($article->getArticleCategId())
                   ->setFonctionId($foncRep->findById((int) $request->request->get('fonction_ask_devis')))
                    ->setDetailProject($request->request->get('post_description_ask_devis'))
                    ->setFirstName($request->request->get('post_firstname_user_ask_devis'))
                    ->setUserName($request->request->get('post_name_user_ask_devis'))
                    ->setPhoneNumber($request->request->get('post_phone_ask_devis'))
                    ->setEmail($request->request->get('post_email_ask_devis'))
                    ->setZipCode($request->request->get('post_zipcode_ask_devis'))
                    ->setCity($cityRep->findById((int) $request->request->get('city')))
                    ->setIsAcceptedCondition(true)
                    ->setDateCrea(new \DateTime('now'))
                    ->setCivility($request->request->get('post_civility_ask_devis'))
                    ->setIsAskDemande(true);
                    //dump($request->request->get('ask_devis_type'));die;

                    try {

                        if($this->sendMail($devis, $article->getArticleCategId(), $serviceRep, $customRep, $abonnementRep, $mailer)) 
                        {
                            $em->persist($devis);
                            $em->flush();
                            $em->commit();
                            
                            return new JsonResponse(['code'=> 200, 
                                                "infos" => 'Votre demmande a été engregistré!,
                                                    Nos professionels le traiterons!!'
                                                ], 200);
                        }

                    } 
                    catch (\Exception $e) {
                        return new JsonResponse(['code'=> 500, 'infos' => $e->getMessage()], 500);
                    }

            }
            //To show ask devis form page from forms data by post
            elseif (!is_null($request->request->get('metier_ask_devis')) && $request->request->get('metier_ask_devis') != '') {
                
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

                //dump($request->request->get('metier_ask_devis')); die;
                $category = $categRep->findOneById((int) $request->request->get('metier_ask_devis'));
                $arrayArticles = $artRep->findByCategory( $category);
                return $this->render('page/post_ask_devis.html.twig', [
                    'types'=> $types, 'articles'=> $arrayArticles,
                    'fonctions'=> $fonctions, 'category'=> $category,
                    'UserProsId'=> $prosId,
                    'popularDevis'=> $popularDevis,
                    'categories'=> $categories,
                ]);

            } else {
                // return self page when it fired null value
                return $this->redirectToRoute('home_page');

            }   
        }
        // To show ask devis form page from link data using parameters
        if($id !== null) {

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

            $category = $categRep->findOneById((int) $id);
            $arrayArticles = $artRep->findByCategory( $category);
            return $this->render('page/post_ask_devis.html.twig', [
                'types'=> $types, 'articles'=> $arrayArticles,
                'fonctions'=> $fonctions, 'category'=> $category,
                'UserProsId'=> $prosId,
                'popularDevis'=> $popularDevis,
                'categories'=> $categories,
            ]);
        }

        // return self page when it fired null value
        return $this->redirectToRoute('home_page');

    }
    

    /**
    * @Route("/space-find-chantier", name="find_chantier_page")
    */
    public function findChantier(Request $request, CitiesRepository $cityRep, CategoryRepository $categRep, PostRepository $postRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep)
    {
        
       if($_POST) {

            //BEGIN REQUEST POST FORM SEARCH
            if(!is_null($request->request->get('CategoryId'))) {

                // dump($request->request->get('CategoryId') . ' ' . $request->request->get('postCity'));die;
                $arrayData = array(1=>  $request->request->get('CategoryId'), 
                                    2=> null, null,
                                    4=> null , 5=> null
                                    );   
                  //When using search city                  
                // if (!is_null($request->request->get('postCity'))) {
                //     $arrayData = array(1=>  $request->request->get('CategoryId'), 
                //                         2=> $request->request->get('CategoryId'), $request->request->get('postCity'),
                //                         4=> null , 5=> null
                //                         );   
                // }

                $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData, 0);
                $postsAds = count( $postsAdsArray ) > 0 ? $postsAdsArray : null;
                //dump($postsAds);die;

                $categories = $categRep->findAllArray();
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
                //get all city
                // $cities =  $cityRep->findAllArray();
                // $cities = count($cities) > 0 ? $cities : null;
                //dump($categories);die;
                return $this->render('page/chantier_find_space.html.twig',[
                    'postsAds' => $postsAds,
                    'popularDevis'=> $popularDevis,
                    'categories'=> $categories,
                    // 'cities'=> $cities,
                    'categLabel'=> $request->request->get('categLabel'),
                    'CategoryId'=> $request->request->get('CategoryId'),

                ]);


            } //END REQUEST POST FORM SEARCH

       } //END POST VIA FORM


       //BEGIN GET LIST BY AJAX PAGINATION

        if(!is_null($request->query->get('category_id')) && !is_null($request->query->get('offset'))) {

            $offset = $request->query->get('offset');
            $arrayData = array(1=>  $request->query->get('category_id'), 
            2=> null, null,
            4=> null , 5=> null
            ); 
            $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData, $offset);
            $postsAds = count( $postsAdsArray ) > 0 ? $postsAdsArray : null;
            if($postsAds !== null) {
            
                

            }


        }

        //END GET LIST BY AJAX PAGINATION
        
        $categories = $categRep->findAllArray();
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
        //get all city
        $cities =  $cityRep->findAllArray();
        $cities = count($cities) > 0 ? $cities : null;

        $postsAds = $postRep->findAllPost(50, 0);
        return $this->render('page/chantier_find_space.html.twig',[
            'postsAds' => $postsAds,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'cities'=> $cities,
        ]);
        
    }

    /**
    * @Route("/space-pro", name="space_pro_page")
    */
    public function spacePro(Request $request, CitiesRepository $cityRep, CategoryRepository $categRep, PostRepository $postRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
              
        $arrayPostAds = Array();
        $postsAds = $postRep->findAllArray();
        foreach($postsAds as $key => $value) {

            $datetime1 = $value->getPostAdsDateCrea();
            $datetime2 = new \DateTime('now');
            $interval = $datetime1->diff($datetime2);
                //Filtering by switch periodity 
                //14 ads less than 30 days
                if((int) $interval->format('%R%a') < 30) {
                    $arrayPostAds[] = $value;
                }
                    
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
        //get all city
        // $cities =  $cityRep->findAllArray();
        // $cities = count($cities) > 0 ? $cities : null;

        return $this->render('page/pro_space.html.twig',[
            'postsAds' => $arrayPostAds,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            // 'cities'=> $cities,
        ]);
            
    }

    /**
    * @Route("/space-find-pro", name="space_find_pro_page")
    */
    public function findPro(Request $request, UserRepository $user, CategoryRepository $categRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, TypeRepository $typeRep)
    {
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

        if (!is_null($request->request->get('filter_CategoryId')) || !is_null($request->request->get('filter_CategoryId')) && !is_null($request->request->get('filter_postCity'))) {
           
            $categoryId = $categRep->findById((int) $request->request->get('filter_CategoryId'));
            $arrayData = array(
                1=> $categoryId, 
                2=> $categoryId, 3=> $request->request->get('filter_postCity')
            );
            $pros = $user->findAllProfessionals($arrayData);
            return $this->render('page/pro_find_space.html.twig', [
                'popularDevis'=> $popularDevis,
                'categories'=> $categories,
            ]);
        }
        $pros = $user->findAllProfessionals();
        return $this->render('page/pro_find_space.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/show-one-detail-pro/{id}", name="show_detail_pro_page")
    */
    public function detailPro($id = null, ArticleRepository $artRep, DevisRepository $devisRep, CommentsRepository $commentRep, ImagesRepository $imageRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, VideosRepository $videoRep, CategoryRepository $categoryRep, EvaluationsRepository $evaluationRep, DocummentRepository $docummentRep, LabelsRepository $labelRep)
    {

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

        return $this->render('page/show_one_detail_pro.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/show-detail-ads/{id}", name="show_detail_ads_page")
    */
    public function detailAds($id = null, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
        
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

        //get detail one devis
        $devis = $devisRep->findById((int) $id);
        $devis = !is_null($devis) ? $devis : null;

        
        return $this->render('premuim/show-one-detail-artisant-ads.html.twig', [
            'devis'=>  $devis,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/view-all-travaux/{id}", name="view_all_tavaux_page")
    */
    public function viewAllTravaux($id = null, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
        $page = 0; $morepage = 20; // Paginations
        
       if($id !== null) {
            $articles = $artRep->findByCategory($categoryRep->findById((int) $id));
            $articles = count($articles) > 0 ? $articles : null;
        }
        else {
            $articles = $artRep->findAllArticles($morepage);
            $articles = count($articles) > 0 ? $articles : null;
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


        return $this->render('page/view_all_art_cat_family_byfilter.html.twig', [
            'articles'=>  $articles,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,

        ]);
        
    }

    /**
    * @Route("/view-art-cat-galery/{id}", name="view_art_cat_galery_page")
    */
    public function galery($id = null, CategoryRepository $categoryRep, ArticleRepository $articleRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep)
    {
        $category = $categoryRep->findById((int) $id);
        $artiles = $articleRep->findByCategory($category);
        $articles = count($artiles) > 0 ? $artiles : null;

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
        
        return $this->render('page/catalog_art_img_galery.html.twig', [
            'artiles'=> $artiles,
            'category'=>  $category,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/how-to-steping", name="how_to_step_page")
    */
    public function howToStep( ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep )
    {
        
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

        return $this->render('page/comment-ca-marche.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/guide-price/category/{categId}/{sousCategId}/{articleId}", name="guide_price_page")
    */
    public function guidePrice($categId = null, $sousCategId = null, $articleId = null, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

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

        if((int) $categId !== null && $sousCategId == null) {

            
            return $this->render('page/guid-price-sous-category.html.twig', [
                'popularDevis'=> $popularDevis,
                'categories'=> $categories,
            ]);
        }

        if((int) $categId !== null && (int) $sousCategId !== null) {

            
            return $this->render('page/guid-price-all-articles-sous-category.html.twig', [
                'popularDevis'=> $popularDevis,
                'categories'=> $categories,
            ]);
        }

        return $this->redirectToRoute('home_page');
        
    }

    /**
    * @Route("/nos-tarif", name="nos_tarif_page")
    */
    public function tarif(ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

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

        return $this->render('page/nos-tarif.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/sites-create", name="site_create_page")
    */
    public function sites(ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

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

        return $this->render('page/sites.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/guides-conseils", name="guides_conseils_page")
    */
    public function guidesConseils()
    {
        return $this->render('page/guids-conseils.html.twig');
        
    }

    /**
    * @Route("/temoingnage-particulier", name="comments_particular_page")
    */
    public function commentsParticular(ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

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

        return $this->render('page/temoingnage-particulier.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/temoingnage-pro", name="comments_pro_page")
    */
    public function commentsPro(ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

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

        return $this->render('page/temoingnage-pro.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    /**
    * @Route("/prince-talks-us", name="prince_talk_page")
    */
    public function princeTalksUs(ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, GuidePriceRepository $guidePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

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

        return $this->render('page/prince-talks-us.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
        ]);
        
    }

    //Function to send mail to each professional
    public function sendMail($devis = null, $category  =null, ServicesRepository $serviceRep, CustomerRepository $customRep, AbonnementRepository $abonnementRep, \Swift_Mailer $mailer)
    {

        $myservices = $serviceRep->findByCategoryId($category);

        // Create the Transport
        // $transport = (new Swift_SmtpTransport('smtp.example.org', 25))
        //     ->setUsername('your username')
        //     ->setPassword('your password');

        // // Create the Mailer using your created Transport
        // $mailer = new Swift_Mailer($transport);
        
        if(count($myservices) > 0) {

            foreach ($myservices as $key => $myservice) {
                $customer = $customRep->findByUser($myservice->getUserId());
                $arrayCriticals = array(1=>  $customer, 2=> $myservice); // prepare query to get abonnement here!
                if ($customer !== null && $myservice->getIsActived() == true && $abonnementRep->isPremiumAndDateExpireValid($arrayCriticals)) 
                {
                    //urlencode($foo) 
                    $message = (new \Swift_Message('DEMANDE DEVIS ORANGE TRAVEAUX'))
                        ->setFrom('florent.tata15@gmail.com')
                        ->setTo('florent.tata23@gmail.com')
                        ->setBody("Test Email", 'text/html');
                        // ->setBody(
                        //     $this->renderView(
                        //         // templates/emails/registration.html.twig
                        //         'premuim/send-email-devis.html.twig',
                        //         ['devis' => $devis]
                        //     ),
                        //     'text/html'
                        // );

                     $mailer->send($message);     

                }
            }
            return true;

        }//END IF TEST SERVICE COUNT HERE

        return false;

    }

    //GET DISTANCE BETWEEN TWO ZIP CODE OR LAT AND LONG
    // This function returns Longitude & Latitude from zip code.
    function getLnt($zip)
    {

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=
        ".urlencode($zip)."&sensor=false&key=[YOUR API KEY]";
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        $result1[]=$result['results'][0];
        $result2[]=$result1[0]['geometry'];
        $result3[]=$result2[0]['location'];
        return $result3[0];

    }
    
    function getDistance($zip1, $zip2, $unit)
    {

        $first_lat = getLnt($zip1);
        $next_lat = getLnt($zip2);
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
            return $miles." ".$unit;
        }

    } //End function get distance 

    

}
