<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Devis;
use App\Entity\Customer;
use App\Entity\Services;
use App\Entity\Type;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\SousCategory;
use App\Entity\ModePrix;
use App\Entity\Configsite;


use App\Repository\ConfigsiteRepository;
use App\Repository\CustomerRepository;
use App\Repository\DevisRepository;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use App\Repository\TransactionRepository;
use App\Repository\AbonnementRepository;
use App\Repository\ArticleRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeRepository;

use App\Repository\SousCategoryRepository;
use App\Repository\ModePrixRepository;
use App\Repository\OptionEmailRepository;


use Doctrine\ORM\EntityManagerInterface;

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
     * @Route("../configsite/{id}/edit", name="configsite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Configsite $configsite): Response
    {
        $form = $this->createForm(ConfigsiteType::class, $configsite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

        }

    }


    /**
    * @Route("/test", name="test")
    */
    public function test()
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		$devis = $this->getDoctrine()
					->getRepository('Controller:Devis')
					->findAll();
		return new Response(count($devis)."  DEVIS ");
					
        //return $this->render('admin/api_admin/nav_bar.html.twig', [
          //  'controller_name' => 'HomeController',
            //'prenom' => 'Lion'
        //]);
		
		//SELECT * FROM `article` ORDER BY `article`.`id` DESC LIMIT 5 OFFSET 0
		
		//SELECT `article`.`article_categ_id_id`,COUNT(*) as nbr, DATE(DATE_ADD(`article`.`article_date_crea`, INTERVAL 1 WEEK)) FROM `article` ORDER BY `article`.`article_categ_id_id` LIMIT 5 OFFSET 0
		
		
		/**
			
			SET lc_time_names = 'fr_FR' ;
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 1
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea` FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 2
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 3
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 4
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 5
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 6
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 7
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 8
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 9
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 10
			UNION
			SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 11
			UNION
            SELECT COUNT(MONTH(`article`.`article_date_crea`)) as total, MONTHNAME (`article`.`article_date_crea`) as mois, `article`.`article_title`, `article`.`article_date_crea`  FROM `article` WHERE MONTH(`article`.`article_date_crea`) = 12
            			
		**/
    }
	
    /**
    * @Route("/", name="admin_home")
    */
    public function index(Security $security, SousCategoryRepository $sousCatRep, DevisRepository $devisRep, ServicesRepository $serviceRep, UserRepository $pro_user_rep, TypeRepository $type_rep, ArticleRepository $art_rep, CategoryRepository $cat_rep,  PostRepository $post_rep, ConfigsiteRepository $configsiteRepository)
    {
        //$this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        $count_sousCat = $sousCatRep->findAll(); 
 		$count_pro = $pro_user_rep->findAll();
 		$count_part = $pro_user_rep->findAll();
		
        $devisPopulars = $devisRep->findTopPopularDevis();
        $devisPopulars = count( $devisPopulars) > 0 ? $devisPopulars : null;
        
        $popularDevis = array();
        if($devisPopulars !== null) {
            foreach ($devisPopulars as $key => $value) {
               $popularDevis[] =  $art_rep->findById($value['article_id']);
            }
        }
        

        $count_devis = $devisRep->findAll();

		$count_type = $type_rep->findAll();
 		$count_article = $art_rep->findAllArray();
		$count_category = $cat_rep->findAll();
		$count_post =  $post_rep->findAll();
		
        return $this->render('admin/index.html.twig', [

            'configsites' => $configsiteRepository->findAll(),
			'page_head_title' => 'DASHBOARD',
            
            'devis' => $count_devis,            
            'numberDevis' => count($count_devis),
            'popularDevis' => $popularDevis,
            'devisPopulars' => $devisPopulars[0],
            
			'numberPro' =>  count($count_pro),
			'numberPart' =>  count($count_part),
        
            'numberType' => count($count_type),
            'numberArt' => count($count_article),
            'numberCat' => count($count_category),
            'numberSousCat' => count($count_sousCat),
            
            'numberPost' => count($count_post)
             
        ]);
    }


    
    

    /**
    * @Route("/dashbord", name="admin_dashbord")
    */
    public function dashbord( )
    { //Security $security, DevisRepository $devisRep, ServicesRepository $serviceRep, UserRepository $pro_user_rep, TypeRepository $type_rep, ArticleRepository $art_rep, CategoryRepository $cat_rep, PostRepository $post_rep
	
        // usually you'll want to make sure the user is authenticated first
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // The second parameter is used to specify on what object the role is tested.
        

        //$this->denyAccessUnlessGranted('ROLE_USER_PROFESSIONAL', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

/*

 		$count_pro = $pro_user_rep->findRolesPro();
		
        
        $count_devis = $devisRep->findAll();
		$count_type = $type_rep->findAll();
 		$count_article = $art_rep->findAll();
		$count_category = $cat_rep->findAll();
		$count_post =  $post_rep->findAll();
		
        return $this->render('admin/index.html.twig', [
			'page_head_title' => 'DASHBOARD',
			'numberDevis' => count($count_devis),
			'numberPro' =>  count($count_pro),
			
			 'numberType' => count($count_type),
			 'numberArt' => count($count_article),
			 'numberCat' => count($count_category),
			 'numberPost' => count($count_post)
			 			 
        ]);
		
		
*/
		
		
        return $this->redirectToRoute('admin_home');
		
		
    }


    // /**
    // * @Route("/login_admin", name="admin_login")
    // */
    // public function login_admin()
    // {
	// 	$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
    //     return $this->render('admin/login_admin.html.twig', [
    //         'controller_name' => 'HomeController',
    //         'prenom' => 'Lion'
    //     ]);
    // }


    /**
    * @Route("/config_site", name="config_site")
    */
    public function config_site(ConfigsiteRepository $configsiteRepository): Response
    {
        
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

		
        return $this->render('admin/config_site.html.twig', [	
            'page_head_title' => 'CONFIGURATION DU SITE',
            'configsites' => $configsiteRepository->findAll()
        ]);
    }
    
    
    /**
    * @Route("/dem_devis", name="dem_devis")
    */
		
    public function dem_devis(Security $security, DevisRepository $devisRep, ServicesRepository $serviceRep, CustomerRepository $customRep, ConfigsiteRepository $configsiteRepository)
    {
        
        
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

		       
        $devis = $devisRep->findAllArray();

        return $this->render('admin/dem_devis.html.twig', [
            'devis' => $devis, 'numberDevis' => $this->countDevis($security, $serviceRep, $devisRep),            
            'configsites' => $configsiteRepository->findAll(),
			'page_head_title' => 'DEMANDE DE DEVIS',
            'isAbonned'=> false
        ]);

    }

    
    
    /**
    * @Route("/setUpdateServiceActived/{userId}/{categoryId}", name="setUpdateServiceActived")
    */
    public function setUpdateServiceActived( $userId = null, $categoryId = null , CategoryRepository $cat_rep, UserRepository $user_rep, ServicesRepository $serviceRep, OptionEmailRepository $optionEmail_rep)
    {                
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
          
        
        
        if ($userId !== null && $categoryId !== null   ) {

            $serviceRep->updateServiceActivedByUserIdAndCategoryId( $userId , $categoryId );

        /*
            $em =  $this->getDoctrine()->getManager();
            $em->beginTransaction();
    
            $user = $user_rep->findById((int) $userId);
            $category = $cat_rep->findById((int) $categoryId);

            $serv = $serviceRep->findAll();


            $em->commit();
            */
            return $this->redirectToRoute('m_e_email');
        }
		       
        $serv = $serviceRep->updateServiceActived();
        $option_email_get = $optionEmail_rep->updateNormale();

        return $this->redirectToRoute('m_e_email');

    }

    
    
    /**
    * @Route("/setUpdateServiceDisable/{idUser}", name="setUpdateServiceDisable")
    */
    public function setUpdateServiceDisable( $idUser = null , ServicesRepository $serviceRep, OptionEmailRepository $oneUpdateService)
    {                
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        
        $serv = $serviceRep->updateServiceDisable();               
        $option_email_get = $oneUpdateService->updateOne();        

        $set_id_actived = $serviceRep->updateService_one_Actived($idUser);                      
        
        return $this->redirectToRoute('m_e_email');

    }
		

    public function countDevis(Security $security, ServicesRepository $serviceRep, DevisRepository $devisRep): ?int
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
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
		
		
		
		
    public function countProUser(Security $security, ServicesRepository $serviceRep, UserRepository $pro_user_rep): ?int
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
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

        $count_pro = $pro_user_rep->findAllProfessionals($arrayData1);
       
        return count($count_pro);
    }
        
    
    /**
    * @Route("/lst_in_pro", name="lst_in_pro")
    */
    public function lst_in_pro(UserRepository $pro_user_rep, ConfigsiteRepository $configsiteRepository )
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		//findAllProfessionalsIstrue
 		$count_pro = $pro_user_rep->findAllProfessionalsIstrue();
		
        //return count($count_pro);
		
		return $this->render('admin/lst_in_pro.html.twig', [
			'page_head_title' => 'PROFESSIONNELS',
            'configsites' => $configsiteRepository->findAll(),
            'numberUserPro' => count($count_pro),
			 'list_pros' => $count_pro
        ]);
		
    }
	
	
    /**
    * @Route("/delete_pro/{id}", name="delete_pro")
    */
    public function delete_pro($id = null, UserRepository $user_rep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
           try {
                $em->beginTransaction();
                $prof = $user_rep->findById((int) $id);
                $em->remove($prof);
                $em->flush();
                $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
        return $this->redirectToRoute('lst_in_pro');
    }
	
	
    /**
    * @Route("/delete_part/{id}", name="delete_part")
    */
    public function delete_part($id = null, CustomerRepository $client_rep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
            try {
                $em->beginTransaction();
                $cli = $client_rep->findById((int) $id);
                $em->remove($cli);
                $em->flush();
                $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
        return $this->redirectToRoute('client');
    }
	
	
    /**
    * @Route("/m_e_email", name="m_e_email")
    */
    public function m_e_email(UserRepository $pro_user_rep, ServicesRepository $service_rep, OptionEmailRepository $option_email_rep, ConfigsiteRepository $configsiteRepository, ServicesRepository $serviceRep )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');        
        		
        $count_pro = $pro_user_rep->findRolesPro();
        
        
        $count_option_email = $option_email_rep->findAll();

        
        $count_service = $service_rep->findAll();
        $count_service = count($count_service) > 0 ? $count_service : [] ;
        
        if (count($count_service) > 0) {
            foreach ($count_service as $key => $value) {
                $listMails[ $value->getUserId()->getId() ] = $value ;
            }
            
        } 
                  
		return $this->render('admin/m_e_email.html.twig', [
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'MODES D’ENVOI D’EMAIL',            
            'list_serv' => $count_service,
            'list_pros' => $count_pro,
            'option_email' => $count_option_email,
            'listMails' => $listMails
        ]);
    }

    
    /**
    * @Route("/trans", name="trans")
    */
    public function trans(TransactionRepository $transRep, ConfigsiteRepository $configsiteRepository )
    { 
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
 		$res_req = $transRep->findAllArray();
		
		//
        return $this->render('admin/trans.html.twig', [	
            'configsites' => $configsiteRepository->findAll(),
			'page_head_title' => 'TRANSACTION',
			'res_trans' => $res_req
        ]);
    }
	
	
	
    /**
    * @Route("/delete_transaction/{id}", name="delete_transaction")
    */
    public function delete_transaction($id = null, TransactionRepository $trans_rep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
           try {
            $em->beginTransaction();
            $trans = $trans_rep->findById((int) $id);
            $em->remove($trans);
            $em->flush();
            $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
		
        return $this->redirectToRoute('trans');
       
    }
    
    
    
	
	
    /**
    * @Route("/delete_type/{id}", name="delete_type")
    */
    public function delete_type($id = null, TypeRepository $type_rep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
           try {
            $em->beginTransaction();
            $trans = $type_rep->findById((int) $id);
            $em->remove($trans);
            $em->flush();
            $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
		
        return $this->redirectToRoute('objet_devis');
       
    }
	
	
	
    /**
    * @Route("/delete_cat/{id}", name="delete_cat")
    */
    public function delete_cat($id = null, CategoryRepository $cat_rep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
           try {
            $em->beginTransaction();
            $trans = $cat_rep->findById((int) $id);
            $em->remove($trans);
            $em->flush();
            $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
		
        return $this->redirectToRoute('objet_devis');
       
    }
	
	

	
    /**
    * @Route("/delete_art/{id}", name="delete_art")
    */
    public function delete_art($id = null, ArticleRepository $art_rep)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
           try {
            $em->beginTransaction();
            $trans = $art_rep->findById((int) $id);
            $em->remove($trans);
            $em->flush();
            $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
		
        return $this->redirectToRoute('objet_devis');
       
    }
	
	


	

    /**
    * @Route("/client", name="client")
    */
    public function client(CustomerRepository $custRepository, ConfigsiteRepository $configsiteRepository)
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        
        $count_cust = $custRepository->findAll();

        
        $count_cust = count($count_cust) >  0 ? $count_cust : [] ;
                 
        
		return $this->render('admin/client.html.twig', [
			'page_head_title' => 'CLIENT',
            'configsites' => $configsiteRepository->findAll(),
			'numbercust' => count($count_cust),
			'list_cust' => $count_cust
        ]);

    }

    
    /**
    * @Route("/abonnement", name="abonnement")
    */
    public function abonnement(AbonnementRepository $abon_rep ,ConfigsiteRepository $configsiteRepository )
    {
		/*
        return $this->render('admin/abonnement.html.twig', [	
			'page_head_title' => 'ABONNEMENT'
        ]);
		*/
		
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		//   findRolesAbon
 		$count_abon = $abon_rep->findAll();		
		
		return $this->render('admin/abonnement.html.twig', [
            'configsites' => $configsiteRepository->findAll(),
			'page_head_title' => 'ABONNEMENT',
			 'numberAbon' => count($count_abon),
			 'abonnements' => $count_abon
        ]);
		
    }

	
    /**
    * @Route("/delete_abonnement/{id}", name="delete_abonnement")
    */
    public function delete_abonnement($id = null, AbonnementRepository $abon_rep)
    {
		
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
        if ($id !== null) {
            $em =  $this->getDoctrine()->getManager();
           try {
            $em->beginTransaction();
            $abonnement = $abon_rep->findById((int) $id);
            $em->remove($abonnement);
            $em->flush();
            $em->commit();
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
		
        return $this->redirectToRoute('abonnement');
       
    }
	
	
	
	
    /**
    * @Route("/service", name="service")
    */
    public function service(ServicesRepository $service_rep ,ConfigsiteRepository $configsiteRepository ) 
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		/*
        return $this->render('admin/service.html.twig', [	
			'page_head_title' => 'SERVICE'
        ]);		
		*/
		
		//   findRolesAbon
		
		
        $count_service = $service_rep->findAll();
        $count_service = count($count_service) > 0 ? $count_service : [] ;
        
		return $this->render('admin/service.html.twig', [
			'page_head_title' => 'SERVICE',
            'configsites' => $configsiteRepository->findAll(),
            'numberService' => count($count_service),
            'list_services' => $count_service            
        ]);
		
    }

    
    
    /**
    * @Route("/service/setServiceDebloque/{id}", name="setServiceDebloque")
    */
    public function setServiceDebloque($id = null, ServicesRepository $serviceRep, OptionEmailRepository $oneUpdateService)
    {
        	
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if ($id !== null) {
           
            try {
                $set_id_actived = $serviceRep->updateService_one_Actived($id);
            } catch (\Throwable $th) {
                return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
            }
        }
        
        return $this->redirectToRoute('service');
      
    }

    
    /**
    * @Route("/service/setServiceBoquer/{id}", name="setServiceBoquer")
    */
    public function setServiceBoquer($id = null, ServicesRepository $serviceRep)
    {
        	
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if ($id !== null) {

            $set_id_actived = $serviceRep->updateSetIdService_Disable($id);
            
        }
        
        return $this->redirectToRoute('service');
      
    }
	
	
    
    /**
     * @Route("/setModeEmail3", name="setModeEmail3", methods={"GET"})
     */
    public function setModeEmail3(Request $req, ServicesRepository $serviceRep ,  OptionEmailRepository $oneUpdateService,  ConfigsiteRepository $configsiteRepository ): Response
    {                
        $entityManager = $this->getDoctrine()->getManager();
        
        //dump( $req->query->get('id') ); die;

        //$serviceRep->updateService_one_Actived( $req->query->get('id'));
        
        //return $this->redirectToRoute('m_e_email');

        if ( $req->query->get('active') == 'true' ) {             
                
            try {

                $entityManager->beginTransaction();
                
                $comment = $serviceRep->findById( (int) $req->query->get('id') );                
                $comment->setIsActived(true);
                
                $entityManager->merge($comment);
                $entityManager->flush();
                $entityManager->commit();
                
                $option_email_get = $oneUpdateService->updateMore();


                return new Response('Envoi Activé');
                //return new JsonResponse(['code'=> 200 ,'infos' => 'Bloqué'], 200);

            } catch (\Throwable $th) {
                return new Response('Erreur serveur ');
                //return new JsonResponse(['code'=> 500 ,'infos' => 'Erreur serveur '], 500);
            }
        }
            
        try {

            $entityManager->beginTransaction();

            $comment = $serviceRep->findById( (int) $req->query->get('id') );
            $comment->setIsActived(false);

            $entityManager->merge($comment);
            $entityManager->flush();
            $entityManager->commit();

            $option_email_get = $oneUpdateService->updateMore();

            return new Response('Envoi Désactivé');            
            //return new JsonResponse(['code'=> 200 ,'infos' => 'Bloqué'], 200);

        } catch (\Throwable $th) {
            return new Response('Erreur serveur');
            //return new JsonResponse(['code'=> 500 ,'infos' => 'Erreur serveur '], 500);
        }

        
    }


    /**
    * @Route("/m_e_email/setEmailDebloque/{id}", name="setEmailDebloque")
    */
    public function setEmailDebloque($id = null, ServicesRepository $serviceRep, OptionEmailRepository $oneUpdateService)
    {
        	
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if ($id !== null) {
           
            try {
                $set_id_actived = $serviceRep->updateService_one_Actived($id);
            } catch (\Throwable $th) {
                return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
            }
        }
        
        return $this->redirectToRoute('m_e_email');
      
    }

    
    /**
    * @Route("/m_e_email/setEmailBoquer/{id}", name="setEmailBoquer")
    */
    public function setEmailBoquer($id = null, ServicesRepository $serviceRep)
    {
        	
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');

        if ($id !== null) {                    
            $set_id_actived = $serviceRep->updateSetIdService_Disable($id);            
        }
        
        return $this->redirectToRoute('m_e_email');
      
    }
	
	
    /**
    * @Route("/delete_service/{id}", name="delete_service")
    */
    public function delete_service($id = null, Security $security, ServicesRepository $serviceRep)
    {
		
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
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
		
        return $this->redirectToRoute('service');
       
    }
	
	

    /**
    * @Route("/objet_devis", name="objet_devis")
    */
    public function objet_devis(TypeRepository $type_rep,ConfigsiteRepository $configsiteRepository, ArticleRepository $art_rep, CategoryRepository $cat_rep)
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		$count_type = $type_rep->findAll();
 		$count_article = $art_rep->findAll();
		$count_category = $cat_rep->findAll();
		
		
        return $this->render('admin/objet_devis.html.twig', [	
			'page_head_title' => 'OBJET DE DEVIS',			
             'configsites' => $configsiteRepository->findAll(),
			 'numberType' => count($count_type),
			 'list_type' => $count_type,
			 
			 'numberType' => count($count_article),
			 'list_art' => $count_article,
			 
			 'numberType' => count($count_category),
			 'list_cat' => $count_category
        ]);
    }


    
    
    /**
    * @Route("/objet_devis/api_type_table", name="api_type_table")
    */
    public function api_type_table(TypeRepository $type_rep)
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
        $count_type = $type_rep->findAll();
        
        return $this->render('admin/api_admin/api_type_table.html.twig', [
			'page_head_title' => 'OBJET DE DEVIS',
			
			 'numberType' => count($count_type),
			 'list_type' => $count_type
        ]);
    }
    
    
    /**
    * @Route("/objet_devis/api_category_table", name="api_category_table")
    */
    public function api_category_table( CategoryRepository $cat_rep)
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		$count_category = $cat_rep->findAll();
        
        return $this->render('admin/api_admin/api_category_table.html.twig', [
			'page_head_title' => 'OBJET DE DEVIS',
			
            'numberType' => count($count_category),
            'list_cat' => $count_category
        ]);
    }
    
    
    
    /**
    * @Route("/objet_devis/api_article_table", name="api_article_table")
    */
    public function api_article_table( ArticleRepository $art_rep )
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
				
        $count_article = $art_rep->findAll();
        
        return $this->render('admin/api_admin/api_article_table.html.twig', [						
         
			 'numberType' => count($count_article),
			 'list_art' => $count_article,
			 
        ]);
    }
    
    
    /**
    * @Route("/objet_devis/api_souscategory_table", name="api_souscategory_table")
    */
    public function api_souscategory_table( SousCategoryRepository $souscat_rep)
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		$count_souscategory = $souscat_rep->findAll();
        
        return $this->render('admin/api_admin/api_souscategory_table.html.twig', [
			'page_head_title' => 'OBJET DE DEVIS',
			
            'numberType' => count($count_souscategory),
            'list_souscat' => $count_souscategory
        ]);
    }
	
    
    /**
    * @Route("/objet_devis/api_mode_prix_table", name="api_mode_prix_table")
    */
    public function api_mode_prix_table( ModePrixRepository $prix_rep)
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'as pas de droit d\'accèder à cette page!');
		
		$count_prix = $prix_rep->findAll();
        
        return $this->render('admin/api_admin/api_mode_prix_table.html.twig', [
			'page_head_title' => 'OBJET DE DEVIS',
            'numberType' => count($count_prix),
            'list_prix' => $count_prix
        ]);
    }
	
    /**
    * @Route("/register_type/{title}", name="register_type")		
	* @param Request $request
    * @return Response
    */
    public function register_type($title = null,Request $request, TypeRepository $type_rep, EntityManagerInterface $em)
    {
        		
        if ($title !== null) {
			
            $em =  $this->getDoctrine()->getManager();
			
           try {
			   
		$em->beginTransaction();
			$type = new Type;
			
			$type->setTitle($title);			
			$type->setDateCrea(new \Datetime());
			
			$em->persist($type);
			
            $em->flush();
            $em->commit();
			
			return $this->redirectToRoute('objet_devis');
			
		
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
        }
		
    }
	
	
	
	
    /**
    * @Route("/register_cat/{title}/{desc}/", name="register_cat")
	* @param Request $request
    * @return Response
    */
    public function register_cat($title = null, $desc = null, Request $request, EntityManagerInterface $em)
    {
        		
        if ($title !== null && $desc !== null ) {
			
            $em =  $this->getDoctrine()->getManager();
			
           try {
				$em->beginTransaction();
				$cat = new Category;
				
				$cat->setCategTitle($title);
				$cat->setDescription($desc);
				
				$cat->setCategDateCrea(new \Datetime());
				
				$em->persist($cat);
				
				$em->flush();
				$em->commit();
				
                return $this->redirectToRoute('objet_devis');
                
			} catch (\Throwable $th) {
				return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
			}
        }
		
    }
	
	
	
    /**
    * @Route("/register_article/{title}/{catId}", name="register_article")
	* @param Request $request
    * @return Response
    */
    public function register_article($title = null, $catId = null, EntityManagerInterface $em)
    {
        		
        if ($title !== null && $catId !== null ) {
            $em =  $this->getDoctrine()->getManager();
			
           try {
			   
			$em->beginTransaction();
			$art = new Article;
			
			$art->setArticleTitle($title);
			$art->setArticleCategId('1');
			$art->setArticleDateCrea(new \Datetime());
			
			$em->persist($art);
			
            $em->flush();
            $em->commit();
			
			return $this->redirectToRoute('objet_devis');
			return $this->redirectToRoute('objet_devis');
						
           } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500 ,'infos' => $th->getMessage()], 500);
           }
		   
        }
		
    }
	
	
/**
* @Route("/update_article/{id}")
*/  
public function update_article(Request $request, $id, ArticleRepository $art_rep) {

  $em = $this->getDoctrine()->getManager();
  
  $article =  $art_rep->findById((int) $id);
  

  if (!$article) {
    throw $this->createNotFoundException(
    'There are no articles with the following id: ' . $id
    );
  }

  $form = $this->createFormBuilder($article)
    ->add('title_art', TextType::class)
    ->add('author', TextType::class)
    ->add('body', TextareaType::class)
    ->add('url', TextType::class,
    array('required' => false, 'attr' => array('placeholder' => 'www.example.com')))
    ->add('save', SubmitType::class, array('label' => 'Update'))
    ->getForm();

  $form->handleRequest($request);

  if ($form->isSubmitted()) {

    $article = $form->getData();
    $em->flush();

    return $this->redirect('/view-article/' . $id);

  }

  return $this->render(
    'article/edit.html.twig',
    array('form' => $form->createView())
    );

}


    /**
    * @Route("/register-verify-email", name="register_verify_email", methods={"GET"})
    * @param Request $request
    * @return Response
    */
    public function verifyEmail( Request $request, UserRepository $userRepo) : Response {
       
        $validator = Validation::createValidator();
        $data = array('_email' => $request->query->get('_email'));
        $constraint = new Assert\Collection(array(
            '_email' => new Assert\Email()
        ));
        $violations = $validator->validate($data, $constraint);
        if ($violations->count() > 0) {
            return new JsonResponse(['code'=> 401, 'infos' => 'Email invalide'], 200);
        }
        try {
            if ($userRepo->findOneByEmail($request->query->get('_email')) != null) {
                return new JsonResponse(['code'=> 401, 'infos'=> $request->query->get('_email') . ' est déjà utilisé'], 200);
            }
        } catch (\Throwable $th) {
            return new JsonResponse(['code'=> 500, 'infos' => $th->getMessage()], 500);
        }
       
        return new JsonResponse(['code'=> 200, 'infos'=> 'votre email est validé'], 200);
    
    }




    
    /** ############## ABONNEMENT ################ **/


}
