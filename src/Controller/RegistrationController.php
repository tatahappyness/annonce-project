<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\CitiesRepository;
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
<<<<<<< HEAD
    {
=======
    { 
>>>>>>> e7df38c4d71ea2b1d454979bebf544300dc2f9c7
       
        $user = new User();
        
        if ($request->request->get('TYPE_USER') !== null && $request->request->get('TYPE_USER') === 'PRO_USER') {
            // register pro
            $category = $categoryRep->findById((int) $request->request->get('metier_ask_devis'));
            $city = $cityRep->findById((int) $request->request->get('city'));
            $user
                ->setRoles(['ROLE_USER_PROFESSIONAL'])
                ->setUserCategoryActivity($category)
                ->setUsername($request->request->get('_username'))
                ->setFirstname($request->request->get('firstname'))
                ->setMobile($request->request->get('phone'))
                ->setEmail($request->request->get('_email'))
                ->setZipCode($request->request->get('zipcode'))
                ->setUserCity($city)
                ->setCompanyName($request->request->get('company_name'))
                ->setFreeDateExpire(new \DateTime('tomorrow'))
                ->setIsAcceptConditionTerm(true)
                ->setIsProfessional(true)
                //->setLat($request->request->get('latitude'))
                //->setog($request->request->get('longitude'))
                ->setPassword($passwordEncoder->encodePassword(
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
<<<<<<< HEAD
                } 
=======
                }
>>>>>>> e7df38c4d71ea2b1d454979bebf544300dc2f9c7
        }

       if ($request->request->get('TYPE_USER') !== null && $request->request->get('TYPE_USER') === 'PARTICULAR_USER') {
            // register particular
            $user
                ->setRoles(['ROLE_USER_PARTICULAR'])
                ->setUsername($request->request->get('_username'))
                ->setEmail($request->request->get('_email'))
                ->setIsAcceptConditionTerm(true)
                ->setIsParticular(true)
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
