<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Article;
use App\Entity\Devis;
use App\Entity\Newletter;
use App\Entity\Siteinternet;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\SousCategoryRepository;
use App\Repository\ArticleRepository;
use App\Repository\ModePrixRepository;
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
use App\Repository\ConfigsiteRepository;
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
    public function home( ArticleRepository $artRep, ConfigsiteRepository $configsiteRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

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
           'guidesPrice'=> 1,
           'configsite'=> $configsite,


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
    * @Route("category/sous-category/{categId}", name="category_sous_category_page")
    */
    public function showSousCategory($categId = null, Request $request, ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, SousCategoryRepository $sousCategRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
        
        //Ajax get by pagination
        if(!is_null($request->query->get('category_id')) && !is_null($request->query->get('offset'))) {
            
            $category = $categoryRep->findById((int) $request->query->get('category_id'));
            $sousCategories = $sousCategRep->findByCategoryId($category, $request->query->get('offset'));
            $sousCategories = count($sousCategories) > 0 ? $sousCategories : [];
            $templeteSousCategory = '';

            if(count($sousCategories) > 0) {

                foreach ($sousCategories as $key => $sousCateg) {
                    
                    $templeteSousCategory .= '';

                }

                return new JsonResponse($templeteSousCategory, 200);

            }

            return new JsonResponse($templeteSousCategory = 0, 200);
        }  

        if($categId !== null) {
            // get sous category by wildcard
            $category = $categoryRep->findById((int) $categId);
            $sousCategories = $sousCategRep->findByCategoryId($category);
            $sousCategories = count($sousCategories) > 0 ? $sousCategories : [];
        
        }
        //get Category
        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories :[];

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

        return $this->render('page/guid-price-sous-category.html.twig', [
            'categories'=> $categories,
            'devisPopulars'=> $devisPopulars,
            'configsite'=> $configsite,
            'sousCategories'=> $sousCategories,
            
            ]);
        

    }

    /**
    * @Route("category/sous-category/guide-price/{sousCategId}", name="category_sous_category_guide_price_page")
    */
    public function showGuidePrice($sousCategId = null, Request $request, SousCategoryRepository $sousCategRep, ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep, ModePrixRepository $modePriceRep, UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {
        
        //Ajax get by pagination
        if(!is_null($request->query->get('sous_category_id')) && !is_null($request->query->get('offset'))) {

            $sousCategory = $sousCategRep->findById((int) $request->query->get('sous_category_id'));
            $modePrices = $modePriceRep->findBySousCategoryId($sousCategory, $request->query->get('offset'));
            $modePrices = count($modePrices) > 0 ? $modePrices : [];
            $templetePrices = '';

            if(count($modePrices) > 0) {

                foreach ($modePrices as $key => $mod) {
                    
                    $templetePrices .= '';

                }

                return new JsonResponse($templetePrices, 200);

            }

            return new JsonResponse($templetePrices = 0, 200);
        }  

        if($sousCategId !== null) {
            // get sous category by wildcard
            $sousCategory = $sousCategRep->findById((int) $sousCategId);
            $modePrices = $modePriceRep->findBySousCategoryId($sousCategory);
            $modePrices = count($modePrices) > 0 ? $modePrices : [];
        
        }
        //get sous Category
        $sousCategories = $sousCategRep->findAllArray();
        $sousCategories = count( $sousCategories) > 0 ? $sousCategories :[];

        
        //Get top devis more asked
                $devisPopulars = $devisRep->findTopPopularDevis();
                $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
                $popularDevis = array();
                if($devisPopulars !== null) {
    
                    foreach ($devisPopulars as $key => $value) {
                    $popularDevis[] =  $artRep->findById($value['article_id']);
                    }
    
                }
        //Get category for menu
        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('page/guid-price-all-articles-sous-category.html.twig', [
            'categories'=> $categories,
            'popularDevis'=> $popularDevis,
            'configsite'=> $configsite,
            'modePrices'=>  $modePrices,
            'sousCategories'=>  $sousCategories,
           
            ]);

    }


    /**
    * @Route("/inscription", name="inscription_page")
    */
    public function inscription(ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

       return $this->render('page/inscription.html.twig', [
           'categories'=> $categories,
           'popularDevis'=> $popularDevis,
           'configsite'=> $configsite
           ]);
        
    }

    /**
    * @Route("/inscription-particulier", name="inscription_particulier_page")
    */
    public function inscriptionParticulier(ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('page/inscription-particular.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/new-letter", name="new_letter_page")
    */
    public function addNewLetter(Request $request)
    {
        
        if($_POST) {

            if($request->request->get('newLetter')) {
                $em = $this->getDoctrine()->getManager();
                $em->beginTransaction();
                $newLetter = new Newletter();
                $newLetter
                    ->setEmail($request->request->get('newLetter'))
                    ->setDateCrea(new \DateTime('now'));

                    $em->persist($newLetter);
                    $em->flush();
                    $em->commit();

                return new JsonResponse(['code'=> 200, 'info'=> 'Votre email est bien envoyé!'], 200);
            }

        }
        return new JsonResponse(['info'=> "vous avez fait un erreur!"], 200);
    }

    /**
    * @Route("/post-ask-devis/{id}/{prosId}", name="post_ask_devis_page" , requirements={"id"="\d+"})
    */
    public function postAskDevis($id = null, $prosId = null, Request $request, ConfigsiteRepository $configsiteRep, DevisRepository $devisRep,   CitiesRepository $cityRep, TypeRepository $typeRep, CategoryRepository $categRep, ArticleRepository $artRep, FonctionRepository $foncRep, ServicesRepository $serviceRep, CustomerRepository $customRep, AbonnementRepository $abonnementRep, \Swift_Mailer $mailer, UserRepository $userRep)
    {       
            //dump($request->request->get('metier_ask_devis'));die;
            //dump($_ENV['MAILER_URL']);die;
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

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

                //dump($request->request->get('metier_ask_devis')); die;
                $category = $categRep->findOneById((int) $request->request->get('metier_ask_devis'));
                $arrayArticles = $artRep->findByCategory( $category);
                    
                return $this->render('page/post_ask_devis.html.twig', [
                    'types'=> $types, 'articles'=> $arrayArticles,
                    'fonctions'=> $fonctions, 'category'=> $category,
                    'UserProsId'=> $prosId,
                    'popularDevis'=> $popularDevis,
                    'categories'=> $categories,
                    'configsite'=> $configsite,
                ]);

            } else {
                // return self page when it fired null value
                return $this->redirectToRoute('home_page');

            }   
        }
        // To show ask devis form page from link data using parameters
        if($id !== null) {

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

            $category = $categRep->findOneById((int) $id);
            $arrayArticles = $artRep->findByCategory( $category);
            return $this->render('page/post_ask_devis.html.twig', [
                'types'=> $types, 'articles'=> $arrayArticles,
                'fonctions'=> $fonctions, 'category'=> $category,
                'UserProsId'=> $prosId,
                'popularDevis'=> $popularDevis,
                'categories'=> $categories,
                'configsite'=> $configsite,
            ]);
        }

        // return self page when it fired null value
        return $this->redirectToRoute('home_page');

    }
    

    /**
    * @Route("/space-find-chantier", name="find_chantier_page")
    */
    public function findChantier(ConfigsiteRepository $configsiteRep, Request $request, CitiesRepository $cityRep, CategoryRepository $categRep, PostRepository $postRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep)
    {
        
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();


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
                    'configsite'=> $configsite,

                ]);


            } //END REQUEST POST FORM SEARCH

       } //END POST VIA FORM


       //BEGIN GET LIST BY AJAX PAGINATION

        if(!is_null($request->query->get('category_id')) && !is_null($request->query->get('offset'))) {
            //dump($request->query->get('category_id') . ' ' . $request->query->get('offset'));die;
            $offset = $request->query->get('offset');
            $arrayData = array(1=>  $request->query->get('category_id'), 
            2=> null, null,
            4=> null , 5=> null
            ); 
            $postsAdsArray = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData, $offset);
            $postsAds = count( $postsAdsArray ) > 0 ? $postsAdsArray : null;
            //dump($postsAds);die;
            $templetePostAds = '';
            if($postsAds !== null) {
            
                foreach ($postsAds as $key => $post) {
                   
                    $templetePostAds .= '<div class="col-12 col-sm-6 col-lg-4 my-2">
                    <div class="card card-pub-artisant text-leftt" style="width: auto;">
                        <div class="card-header">
                            <div class="d-flex flex-column align-items-center justify-content-center w-100 pt-4">
                                <h4 class="card-title text-warning text-center px-2">' . $post->getArticleId()->getArticleTitle() . '</h4>
                                <span class="ads-icon text-center">
                                    <span class="icon" style="height: 128px;">
                                        <object type="image/svg+xml" data="/uploads/icons/"' . $post->getArticleId()->getIcon() . '"  class="icon icon-bike">
                                            Bike
                                        </object>
                                    </span>
                                <span>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-secondary">' . $post->getPostAdsDateCrea()->format('d/m/Y H:m:s') . '</p>
                            <p class="card-text motif-pub">{{ post.getPostAdsTravauxDescription() }}</p>
                            <p class="text-secondary small">Postulé par: ' . $post->getPostUserId()->getFirstname() . '</p><br>
                            <a class="text-warning float-right" href="/show-detail-ads/"' . $post->getId() . '">voir le chantier >></a>
                        </div>
                    <div class="card-footer text-secondary text-center mt-0 py-2">
                      
                    </div>
                    </div>
                </div>' ;
                    

                }

                return new JsonResponse($templetePostAds, 200);

            }

            return new JsonResponse($templetePostAds = 0, 200);

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
        // $cities =  $cityRep->findAllArray();
        // $cities = count($cities) > 0 ? $cities : null;

        $postsAds = $postRep->findAllPost(50, 0);
        return $this->render('page/chantier_find_space.html.twig',[
            'postsAds' => $postsAds,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            // 'cities'=> $cities,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/space-pro", name="space_pro_page")
    */
    public function spacePro(ConfigsiteRepository $configsiteRep, Request $request, CitiesRepository $cityRep, CategoryRepository $categRep, PostRepository $postRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   TypeRepository $typeRep, CategoryRepository $categoryRep)
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

        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        //get all city
        // $cities =  $cityRep->findAllArray();
        // $cities = count($cities) > 0 ? $cities : null;

        return $this->render('page/pro_space.html.twig',[
            'postsAds' => $arrayPostAds,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            // 'cities'=> $cities,
            'configsite'=> $configsite,
        ]);
            
    }

    /**
    * @Route("/space-find-pro", name="space_find_pro_page")
    */
    public function findPro(Request $request, UserRepository $userRep, ConfigsiteRepository $configsiteRep, CategoryRepository $categRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   TypeRepository $typeRep)
    {
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

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

            //Request POST
            if ($_POST) {
                
                if (!is_null($request->request->get('CategoryId')) && !is_null($request->request->get('categLabel'))) {
           
                    $categoryId = $categRep->findById((int) $request->request->get('CategoryId'));
                    $arrayData = array(
                        1=> true, 
                        2=> $categoryId, 3=> null, 4=> null, 5=> null
                    );
                    $pros = $userRep->findAllProfessionals($arrayData);
                    $pros = count($pros) > 0 ?  $pros : null;
                    return $this->render('page/pro_find_space.html.twig', [
                        'popularDevis'=> $popularDevis,
                        'categories'=> $categories,
                        'pros'=> $pros,
                        'categoryId'=> $request->request->get('categoryId'),
                        'categLabel'=> $request->request->get('categLabel'),
                        'configsite'=> $configsite,
                    ]);
                }
            } //END POST

            //GET LIST PROS BY AJAX PAGINATION
            if (!is_null($request->query->get('category_id')) && !is_null($request->query->get('offset'))) {
                //dump($request->query->get('category_id'));die;
                $offset = $request->query->get('offset');
                $categoryId = $categRep->findById((int) $request->query->get('categoryId'));
                $arrayData = array(
                    1=> true, 
                    2=> $categoryId, 3=> null, 4=> null, 5=> null
                );
                $pros = $userRep->findAllProfessionals($arrayData, (int) $offset);
                $pros = count($pros) > 0 ?  $pros : null;
                //dump($pros);die;
                $templatePros = '';

                if ($pros !== null) {
                   
                    foreach ($pros as $key => $pro) {
                        
                        $templatePros .= '<div class="col-12 col-sm-6 col-lg-4 my-2">
                        <div class="img-new-pro-container d-flex flex-column align-items-center justify-content-center bg-white rounded">
                            <div class="img-new-pro-content rounded-top" style="background-image: url(/uploads/images/' . $pro->getUserCategoryActivity()->getImg() . '); width: 100%; height: 250px;">
                                <div class="w-100">
                                    <a class="btn btn-warning float-left m-1 text-white">' . $pro->getUserCategoryActivity()->getCategTitle() . '</a>
                                    <a class="btn btn-warning btn-pro-emotion-heart rounded-circle float-right m-1">
                                        <span class="lnr lnr-heart icon-pro-emotion-heart"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="img-pro-desc d-flex flex-row align-items-center justify-content-center  text-center py-2">
                                <div class="border border-secondary rounded-circle">
                                    <img class="pro-logo rounded-circle" src="/uploads/logo/' . $pro->getLogo() . '" style="width: 64px; height: 64px;"></img>
                                </div>
                                <div class="d-flex flex-column align-items-center justify-content-center text-left">
                                    <span class="d-inline text-center">
                                        <a class="btn btn-outline-secondary m-2">En vedette</a>
                                        <a class="btn btn-outline-secondary m-2">vérifié</a>
                                    </span>
                                    <span class="text-center ml-1">
                                        <a href="/show-one-detail-pro/' . $pro->getId() . '" class="text-decoration-none text-secondary">' . $pro->getCompanyName() . '</a>
                                    </span>
                                    <span class="small text-center">
                                        <span class="pro-point-star p-1"><span class="lnr lnr-star icon-star-pro text-warning"></span><span class="lnr lnr-star icon-star-pro text-warning"></span><span class="lnr lnr-star icon-star-pro text-warning"></span><span class="lnr lnr-star-half icon-star-pro text-warning"></span></span>
                                        <span class="pro-like-percent text-secondary p-1"><span class="lnr lnr-thumbs-up icon-like-pro text-secondary"></span> 99% (1009 votes) </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>';

                    }
                    
                    return new JsonResponse($templatePros, 200);
                }

                return new JsonResponse($templatePros = 0, 200);

            } //END LIST AJAX PAGINATION

        $pros = $userRep->findAllProfessionals();
        return $this->render('page/pro_find_space.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'pros'=> $pros,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/show-one-detail-pro/{id}", name="show_detail_pro_page")
    */
    public function detailPro($id = null, ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, DevisRepository $devisRep, CommentsRepository $commentRep, ImagesRepository $imageRep,   UserRepository $userRep, VideosRepository $videoRep, CategoryRepository $categoryRep, EvaluationsRepository $evaluationRep, DocummentRepository $docummentRep, LabelsRepository $labelRep)
    {

        //get pros user one infos company
        $user = $userRep->findOneById((int) $id);
        //get images chantier realize
        $images = $imageRep->findByUserId(array(1=> $user));
        $images = count($images) > 0 ? $images : [];
        //get Evaluations
        $evaluations = $evaluationRep->findByUserId(array(1=> $user));
        $evaluations = count($evaluations) > 0 ? $evaluations : [];
        //get Quality Label
        $labels = $labelRep->findByUserId(array(1=> $user));
        $labels = count($labels) > 0 ? $labels : [];
        //get Documment entreprise
        $documents = $docummentRep->findByUserId(array(1=> $user));
        $documents = count($documents) > 0 ? $documents : [];
        //get Viddeos chantier realize
        $videos = $videoRep->findByUserId(array(1=> $user));
        $videos = count($videos) > 0 ? $videos : [];

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

        return $this->render('page/show_one_detail_pro.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'user'=> $user,
            'images'=>  $images,
            'videos'=> $videos,
            'evaluations'=> $evaluations,
            'labels'=> $labels,
            'documents'=> $documents,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/show-detail-ads/{id}", name="show_detail_ads_page")
    */
    public function detailAds($id = null, ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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
        
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('premuim/show-one-detail-artisant-ads.html.twig', [
            'devis'=>  $devis,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/view-all-travaux/{id}", name="view_all_tavaux_page")
    */
    public function viewAllTravaux($id = null, Request $request, ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

        //BEGIN GET LIST ARTICLES BY AJAX PAGINATION
        if($request->query->get('category_id') !== null && $request->query->get('offset') !== null) {
            //dump($request->request->get('CategoryId'));die;
            $offset = $request->query->get('offset');
            $articles = $artRep->findByCategory($categoryRep->findById((int) $request->query->get('category_id'), $offset));
            $articles = count($articles) > 0 ? $articles : [];
            $templateArticles = '';

            if (count($articles) > 0) {
                   
                foreach ($articles as $key => $art) {
                        
                    $templateArticles .= '<div class="col-12 col-sm-6 col-lg-4 my-2">
                                <div data-id="' .$art->getId() . '" class="img-new-pro-container article-image-show bg-white rounded" style="border: 4px solid white;">
                                    <div class="img-new-pro-content d-flex flex-column rounded-top" style="background-image: url(/uploads/images/' . $art->getImg() . '); width: 100%; height: 250px;">
                                        <div class="bg-transparent w-100" style="">
                                            <a href="/view-art-cat-galery/' . $art->getArticleCategId()->getid() . '" class="btn bg-success icon-pro-img-over d-none text-decoration-none float-right m-2">
                                                <span class="lnr lnr-eye icon-popular-ask-eyes"></span>
                                            </a>
                                        </div>
                                        <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                                            <a id="item-' . $art->getId() . ' href="/post-ask-devis/' . $art->getArticleCategId()->getid() . '" class="btn-warning btn-pro-emotion-heart d-none text-decoration-none p-3 rounded">
                                                Demander un devis
                                            </a>
                                            <span class="h6 text-white p-2">' . $art->getArticleTitle() . '</span>
                                        </div>
                                        <div class="bg-transparent d-flex align-items-end justify-content-end h-auto w-100 pb-3" style=""><a class="btn bg-darkgray icon-pro-img-over d-none m-2">vote(3215)</a></div>
                                    </div>
                                </div>
                            </div>';
                        
                }
                    
                return new JsonResponse($templateArticles, 200);
            }

            return new JsonResponse($templateArticles = 0, 200);
                


        } //END GET LIST ARTICLES BY AJAX PAGINATION

        $categoryId = '';
        $labelCategory = '';
        $articles = $artRep->findByCategory();
        $articles = count($articles) > 0 ? $articles : [];

        //Begin POST VIEW ALL TRAVAUX
        if($_POST) {

            if($request->request->get('CategoryId') !== null) {
                //dump($request->request->get('CategoryId'));die;
                $articles = $artRep->findByCategory($categoryRep->findById((int) $request->request->get('CategoryId')));
                $articles = count($articles) > 0 ? $articles : [];
                $categoryId = $request->request->get('CategoryId');
                $labelCategory = $request->request->get('categLabel');
            }

        } //END POST VIEW ALL TRAVAUX

       if($id !== null) {
            $articles = $artRep->findByCategory($categoryRep->findById((int) $id));
            $articles = count($articles) > 0 ? $articles : [];
            $categoryId = $id;
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

        return $this->render('page/view_all_art_cat_family_byfilter.html.twig', [
            'articles'=>  $articles,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
            'categLabel'=> $labelCategory,
            'categoryId'=> $categoryId,

        ]);
        
    }

    /**
    * @Route("/view-art-cat-galery/{id}", name="view_art_cat_galery_page")
    */
    public function galery($id = null, ConfigsiteRepository $configsiteRep, CategoryRepository $categoryRep, ArticleRepository $articleRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep)
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();
        
        return $this->render('page/catalog_art_img_galery.html.twig', [
            'artiles'=> $artiles,
            'category'=>  $category,
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/how-to-steping", name="how_to_step_page")
    */
    public function howToStep( ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep )
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('page/comment-ca-marche.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
        ]);
        
    }


    /**
    * @Route("/nos-tarif", name="nos_tarif_page")
    */
    public function tarif(ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('page/nos-tarif.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/sites-create", name="site_create_page")
    */
    public function sites(Request $request, ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
    {

 
        if($_POST) {

            if($request->request->get('firstname') && $request->request->get('name') && $request->request->get('email') && $request->request->get('phone')) {
                $em = $this->getDoctrine()->getManager();
                $em->beginTransaction();
                $site = new Siteinternet();
                $site
                    ->setEmail($request->request->get('email'))
                    ->setFirstname($request->request->get('firstname'))
                    ->setName($request->request->get('name'))
                    ->setPhone($request->request->get('phone'))
                    ->setDateCrea(new \DateTime('now'));

                    $em->persist($site);
                    $em->flush();
                    $em->commit();

                return new JsonResponse(['code'=> 200, 'info'=> 'Vos infomations bien envoyé!, vous serez reçevoir des devis par e-mail.'], 200);
            }

            return new JsonResponse(['info'=> "vous avez fait un erreur!"], 200);

        } // END POST
        

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

        return $this->render('page/sites.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
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
    public function commentsParticular(ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('page/temoingnage-particulier.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/temoingnage-pro", name="comments_pro_page")
    */
    public function commentsPro(ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('page/temoingnage-pro.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
        ]);
        
    }

    /**
    * @Route("/prince-talks-us", name="prince_talk_page")
    */
    public function princeTalksUs(ConfigsiteRepository $configsiteRep, ArticleRepository $artRep, CommentsRepository $commentRep, DevisRepository $devisRep,   UserRepository $userRep, TypeRepository $typeRep, CategoryRepository $categoryRep)
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
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();

        return $this->render('page/prince-talks-us.html.twig', [
            'popularDevis'=> $popularDevis,
            'categories'=> $categories,
            'configsite'=> $configsite,
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

        return true;

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
