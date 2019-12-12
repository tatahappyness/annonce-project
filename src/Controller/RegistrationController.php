<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Services;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\CitiesRepository;
use App\Repository\ConfigsiteRepository;
use App\Repository\ThemeImageRepository;
use App\Repository\ThemeColorRepository;
use App\Repository\ThemeRepository;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @param  UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, CategoryRepository $categoryRep, CitiesRepository $cityRep) : Response
    { 
       
        $user = new User();
        $service = new Services();
        
        if ($request->request->get('TYPE_USER') !== null && $request->request->get('TYPE_USER') === 'PRO_USER') {
            // register pro
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->beginTransaction();
            $category = $categoryRep->findById((int) $request->request->get('CategoryId'));
            $city = $cityRep->findById((int) $request->request->get('city'));
            $token = bin2hex(random_bytes(50)); // generate unique token
            $user
                ->setRoles(['ROLE_USER_PROFESSIONAL'])
                ->setUserCategoryActivity($category)
                ->setUsername($request->request->get('_username'))
                ->setFirstname($request->request->get('firstname'))
                ->setMobile($request->request->get('phone'))
                ->setEmail($request->request->get('_email'))
                ->setZipCode($request->request->get('zipcode'))
                ->setUserCity($city)
                ->setNumDepartement($city->getVilleDepartement())
                ->setToken($token)
                ->setCompanyName($request->request->get('company_name'))
                ->setDateCrea(new \DateTime('now'))
                ->setFreeDateExpire(new \DateTime('tomorrow'))
                ->setIsAcceptConditionTerm(true)
                ->setIsProfessional(true)
                //->setLat($request->request->get('latitude'))
                //->setog($request->request->get('longitude'))
                ->setPassword($passwordEncoder->encodePassword(
                        $user,
                        $request->request->get('_password')
                    ));
               //Add service pros when is registered
                $service
                    ->setUserId($user)
                    ->setCategoryId($category)
                    ->setDateCrea(new \DateTime('now'));

                try {
        
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $entityManager->persist($service);
                    $entityManager->flush();

                    $entityManager->commit();


                    $transport = new \Swift_SmtpTransport();
                        $transport
                        ->setHost('smtp.gmail.com')
                        ->setEncryption('ssl')
                        ->setPort(465)  
                        ->setAuthMode('login')
                        ->setUsername($configsite->getEmail())
                        ->setPassword('bnzkglnpuhzlxlgp');
            
                    // Create the Mailer using your created Transport
                    $mailer = new \Swift_Mailer($transport);
                    $mailer->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    $message = (new \Swift_Message('CONFIRMER VOTRE COMPTE BY ORANGE-TRAVAUX'))
                    ->setFrom($configsite->getEmail())
                    ->setTo($myservice->getUserId()->getEmail())
                    ->setBody('<p>BONJOUR, <p>Veuillez trouvez un lien de comfirmation ci-dessous: </p> </p><p><a style="color: blue;" href="' . $_SERVER['HTTP_HOST'] . '/customer-email-comfirm/client/' .  $token . '">COMFIRMER, Cliquez ici</a></p>', 'text/html', 'utf-8');

                    $result =  $mailer->send($message);

                    if( $result == 1) {
                        return new JsonResponse(['code'=> 200, "infos" => 'Vous êtes inscrit!, Nous avons evoyés un lien de comfirmation dans votre boite email, Veuillez '], 200);
                    }
                    
                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'infos' => $e->getMessage()], 500);
                }
        }

       if ($request->request->get('TYPE_USER') !== null && $request->request->get('TYPE_USER') === 'PARTICULAR_USER') {
            // register particular
            $token = bin2hex(random_bytes(50)); // generate unique token
            
            $user
                ->setRoles(['ROLE_USER_PARTICULAR'])
                ->setUsername($request->request->get('_username'))
                ->setEmail($request->request->get('_email'))
                ->setMobile($request->request->get('phone'))
                ->setToken($token)
                ->setIsAcceptConditionTerm(true)
                ->setIsParticular(true)
                ->setDateCrea(new \DateTime('now'))
                ->setPassword($passwordEncoder->encodePassword(
                        $user,
                        $request->query->get('_password')
                    ));
                $entityManager = $this->getDoctrine()->getManager();
                try {
        
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return new JsonResponse(['code'=> 200, "infos" => 'Vous êtes inscrit!'], 200);
                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'infos' => $e->getMessage()], 500);
                }
            
        }

       if($request->request->get('TYPE_USER') !== null && $request->request->get('TYPE_USER') === 'ADMIN_USER') {
            //we need to verify email and username if is existed, return request data
            // register admin
            $user
                ->setRoles(['ROLE_ADMIN'])
                ->setUsername($request->request->get('_username'))
                ->setEmail($request->request->get('_email'))
                ->setPassword((string) $passwordEncoder->encodePassword(
                        $user,
                        $request->request->get('_password')
                    ));
                $entityManager = $this->getDoctrine()->getManager();
                try {
    
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return new JsonResponse(['code'=> 200, "infos" => 'Vous êtes inscrit!'], 200);
                } 
                catch (\Exception $e) {
                    return new JsonResponse(['code'=> 500, 'infos' => $e->getMessage()], 500);
                }
        }
        
    }

    /**
    * @Route("/email-comfirm", name="email_comfirm")
    */
    public function emailComfirm(ConfigsiteRepository $configsiteRep, CategoryRepository $categoryRep, ThemeRepository $themeRep, ThemeColorRepository $themeColorRep, ThemeImageRepository $themeImageRep)
    {
        $categories = $categoryRep->findAllArray();
        $categories = count( $categories) > 0 ? $categories : null;
        //Get config site
        $configsite = $configsiteRep->findOneByIsActive();
        //THEMES PAGES
        $thems =  $themeRep->findAllArray();
        $themeImages = $themeImageRep->findAllArray();
        $themeColors = $themeColorRep->findAllArray();
        $thems = count($thems) > 0 ? $thems : [];
        $themeImages = count($themeImages) > 0 ? $themeImages : [];
        $themeColors = count($themeColors) > 0 ? $themeColors : [];
        $them = array();
        $themes = array();
        $themesColor = array();

        if(count($thems) > 0) {
            foreach($thems as $key => $value) {
                $them[$value->getKeyWord()] = $value;
            }
        }
        //dump($them);die;

        if(count($themeImages) > 0) {
            foreach($themeImages as $key => $value) {
                $themes[$value->getThemeId()->getKeyWord()][$value->getKeyWord()] = $value;
            }
        }
        //dump($themes);die;

        if(count($themeColors) > 0) {
            foreach($themeColors as $key => $value) {
                $themesColor[$value->getThemeId()->getKeyWord()][$value->getKeyWord()] = $value;
            }
        }
        //dump($themesColor);die;

        return $this->render('page/page-email-comfirm.html.twig', [
            'categories'=> $categories,
            'configsite'=> $configsite,
            'themesImage'=> $themes,
            'themesColor'=> $themesColor,
            'themes'=> $them,
        ]);
    }


    /**
    * @Route("/customer-email-comfirm/client/{token}", name="pro_customer_email_comfirm")
    */
    public function confirmEmail($token = null, Security $security)
    {
        if ($token === $security->getUser()->getToken()) {

            $user = $security->getUser();
            $user
                ->setIsVerified(true);
            $entityManager = $this->getDoctrine()->getManager();
            try {
        
                $entityManager->merge($user);
                $entityManager->flush();
                return $this->redirectToRoute('pro_dashbord');
            } 
            catch (\Exception $e) {
                return new JsonResponse(['code'=> 500, 'info' => $e->getMessage()], 500);
            }

        }
        return $this->redirectToRoute('logout');
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

   
}
