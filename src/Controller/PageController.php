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
use App\Repository\FonctionRepository;
use App\Repository\PostRepository;
use App\Repository\CitiesRepository;
use App\Repository\CommentsRepository;
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
    public function home( ArticleRepository $artRep, TypeRepository $typeRep)
    {
        
       try {
           
        $arrayarticles = $artRep->findAll();
        $arraytypes = $typeRep->findAll();
        $articles =  !is_null($arrayarticles) ? $arrayarticles : null;
        $types = !is_null($arraytypes) ? $arraytypes : null;

       } catch (\Throwable $th) {
        return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
       }
        return $this->render('page/home/accueil.html.twig', [
            'articles'=> $articles, 'types'=> $types
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
                $arrayCity[] = [ 'value'=> $value->getId() , 'label'=> $value->getVilleNomReel() ];
            }

            return  new JsonResponse($arrayCity, 200);
            
        } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
        }  
        
    }

    /**
    * @Route("/inscription", name="inscription_page")
    */
    public function inscription(ArticleRepository $artRep, TypeRepository $typeRep)
    {
      
       return $this->render('page/inscription.html.twig');
        
    }

    /**
    * @Route("/inscription-particulier", name="inscription_particulier_page")
    */
    public function inscriptionParticulier()
    {
        return $this->render('page/inscription-particular.html.twig');
        
    }

    /**
    * @Route("/get-articles", name="get_articles_page")
    */
    public function articles()
    {
        return new JsonResponse(['code'=> 200], 200);
<<<<<<< HEAD

=======
        
>>>>>>> e7df38c4d71ea2b1d454979bebf544300dc2f9c7
    }

    /**
    * @Route("/post-ask-devis/{article}/{id}", name="post_ask_devis_page", requirements={"id"="\d+"})
    */
    public function postAskDevis($article= null, $id = null, Request $request,CitiesRepository $cityRep, TypeRepository $typeRep, CategoryRepository $categRep, ArticleRepository $artRep, FonctionRepository $foncRep)
    {

        $arrayTypes = $typeRep->findAllArray();
        $arrayArticles = $artRep->findAllArray();
        $articles =  !is_null($arrayArticles) ? $arrayArticles : null;
        $types = !is_null($arrayTypes) ? $arrayTypes : null;
        $arrayFonctions = $foncRep->findAllArray();
        $fonctions = !is_null($arrayFonctions) ? $arrayFonctions : null;

        if ($_POST) {
            // Posting Ask in Server data base
            if(!is_null($request->request->get('post_metier_ask_devis')) && !is_null($request->request->get('post_description_ask_devis')) && !is_null($request->request->get('post_email_ask_devis')) && !is_null($request->request->get('post_zipcode_ask_devis')) && !is_null($request->request->get('post_phone_ask_devis'))){
                $devis = new Devis();
                //dump($request->request->get('ask_devis_type'));die;
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
                    ->setDateCrea(new \DateTime())
                    ->setCivility($request->request->get('post_civility_ask_devis'))
                    ->setIsAskDemande(true);

                    try {

                       $em = $this->getDoctrine()->getManager();
                        $em->persist($devis);
                       $em->flush();
                        return new JsonResponse(['code'=> 200, 
                                        "infos" => 'Votre demmande a été engregistré!,
                                            Nos professionels le traiterons!!'
                                        ], 200);
                    } 
                    catch (\Exception $e) {
                        return new JsonResponse(['code'=> 500, 'infos' => $e->getMessage()], 500);
                    }

            }
            //To show ask devis form page from forms data by post
            elseif (!is_null($request->request->get('metier_ask_devis')) && $request->request->get('metier_ask_devis') != '') {
                
                //dump($request->request->get('metier_ask_devis')); die;
                $category = $categRep->findOneById((int) $request->request->get('metier_ask_devis'));
                $arrayArticles = $artRep->findByCategory( $category);
                return $this->render('page/post_ask_devis.html.twig', [
                    'types'=> $types, 'articles'=> $arrayArticles,
                    'fonctions'=> $fonctions, 'category'=> $category
                ]);

            } else {
                // return self page when it fired null value
                return $this->redirectToRoute($request->request->get('route_page'));

            }   
        }
        // To show ask devis form page from link data using parameters
        if($id !== null) {

            $article_found = $artRep->findOneById( (int) $id);
            return $this->render('page/post_ask_devis.html.twig', [
                'types'=> $types, 'articles'=> $articles,
                'articlefound'=>  $article_found,
                'fonctions'=> $fonctions
            ]);
        }

        // Go to create new project page
        return $this->render('page/post_ask_devis.html.twig', [
            'types'=> $types, 'articles'=> $articles,
            'fonctions'=> $fonctions
        ]);

    }

    /**
    * @Route("/space-find-chantier", name="find_chantier_page")
    */
    public function findChantier(Request $request, CategoryRepository $categRep, PostRepository $postRep)
    {
        //HERE GET PROJECT ADS DISPO BY Filter or all or periodity
        if(!is_null($request->request->get('filter_CategoryId')) || !is_null($request->request->get('filter_CategoryId')) && !is_null($request->request->get('filter_postCity'))) {
            
            $CategoryId = $categRep->findById((int) $request->request->get('filter_CategoryId'));
           
            $arrayData = array(1=> $CategoryId,
                                2=> $CategoryId, 3=> $postCity = 3, 
                                4=> null, 5=> null
                            );
            $postsAds = $postRep->filterByCategoryOrCityOrZipcodeOrDepartement($arrayData);

            if(!is_null($request->request->get('switch_periodity'))) {
                $arrayPostAds = Array();
                foreach ($postsAds as $key => $value) {

                    $datetime1 = $value->getPostAdsDateCrea();
                    $datetime2 = new \DateTime('now');
                    $interval = $datetime1->diff($datetime2);

                        if ((int) $interval->format('%R%a') < (int) $request->request->get('switch_periodity')) {
                            $arrayPostAds[] = $value;
                        }
                    
                }
                return $this->render('pro/projects-dispos.html.twig', [
                    'postsAds' => $arrayPostAds,
                ]);
            }
            
            return $this->render('page/chantier_find_space.html.twig',[
                'postsAds' => $postsAds,
            ]);
           
        }

        $postsAds = $postRep->findAllPost(50, 0);
        return $this->render('page/chantier_find_space.html.twig',[
            'postsAds' => $postsAds,
        ]);
        
    }

    /**
    * @Route("/space-pro", name="space_pro_page")
    */
    public function spacePro(Request $request, CategoryRepository $categRep, PostRepository $postRep)
    {

        $arrayPostAds = Array();
        $postsAds = $postRep->findAllArray();
        foreach ($postsAds as $key => $value) {

            $datetime1 = $value->getPostAdsDateCrea();
            $datetime2 = new \DateTime('now');
            $interval = $datetime1->diff($datetime2);
                //14 means 30 months
                if ((int) $interval->format('%R%a') < 30) {
                    $arrayPostAds[] = $value;
                }
                    
        }
        return $this->render('page/pro_space.html.twig',[
            'postsAds' => $arrayPostAds,
        ]);;
        
    }

    /**
    * @Route("/space-find-pro", name="space_find_pro_page")
    */
    public function findPro(Request $request, UserRepository $user, CategoryRepository $categRep)
    {
        if (!is_null($request->request->get('filter_CategoryId')) || !is_null($request->request->get('filter_CategoryId')) && !is_null($request->request->get('filter_postCity'))) {
           
            $categoryId = $categRep->findById((int) $request->request->get('filter_CategoryId'));
            $arrayData = array(
                1=> $categoryId, 
                2=> $categoryId, 3=> 'city'
            );
            $pros = $user->findAllProfessionals($arrayData);
            return $this->render('page/pro_find_space.html.twig');
        }
        $pros = $user->findAllProfessionals();
        return $this->render('page/pro_find_space.html.twig');
        
    }

    /**
    * @Route("/show-one-detail-pro", name="show_detail_pro_page")
    */
    public function detailPro()
    {
        return $this->render('page/show_one_detail_pro.html.twig');
        
    }

    /**
    * @Route("/show-detail-ads", name="show_detail_ads_page")
    */
    public function detailAds()
    {
        return $this->render('premuim/show-one-detail-artisant-ads.html.twig');
        
    }

    /**
    * @Route("/view-all-travaux", name="view_all_tavaux_page")
    */
    public function viewAllTravaux($page = 0, $morepage = 12)
    {
        return $this->render('page/view_all_art_cat_family_byfilter.html.twig');
        
    }

    /**
    * @Route("/view-art-cat-galery", name="view_art_cat_galery_page")
    */
    public function galery()
    {
        return $this->render('page/catalog_art_img_galery.html.twig');
        
    }

    /**
    * @Route("/how-to-steping", name="how_to_step_page")
    */
    public function howToStep()
    {
        return $this->render('page/comment-ca-marche.html.twig');
        
    }

    /**
    * @Route("/nos-tarif", name="nos_tarif_page")
    */
    public function tarif()
    {
        return $this->render('page/tarif.html.twig');
        
    }

    /**
    * @Route("/sites-create", name="site_create_page")
    */
    public function sites()
    {
        return $this->render('page/sites.html.twig');
        
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
    public function commentsParticular()
    {
        return $this->render('page/temoingnage-particulier.html.twig');
        
    }

    /**
    * @Route("/temoingnage-pro", name="comments_pro_page")
    */
    public function commentsPro()
    {
        return $this->render('page/temoingnage-pro.html.twig');
        
    }

    /**
    * @Route("/prince-talks-us", name="prince_talk_page")
    */
    public function princeTalksUs()
    {
        return $this->render('page/prince-talks-us.html.twig');
        
    }
    

}
