<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @Route("/auth")
*/
class ApiAuthController extends AbstractController
{
    /**
    * @Route("/register", name="api_auth_register",  methods={"POST"})
    * @param Request $request
    * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //$this->denyAccessUnlessGranted('view', $user);
       $data = json_decode($request->getContent(), true);

        $user = new User();
        $user
        ->setRoles(['ROLE_USER'])
        ->setUsername((string) $data['username'])
        ->setEmail((string) $data['email'])
        ->setPassword((string) $passwordEncoder->encodePassword(
                $user,
                $data['password']
            ));

        $entityManager = $this->getDoctrine()->getManager();
        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }

        // return new JsonResponse(["success" => $user->getUsername(). " has been registered!"], 200);
        # Code 307 preserves the request method, while redirectToRoute() is a shortcut method.
        return $this->redirectToRoute('api_auth_login', [
            'username' => $data['username'],
            'password' => $data['password']
        ], 307);
    }

    /**
     * @Route("/user/{id}", name="api_user_detail", methods="{GET}")
     * @param User $user
     * @return Response
     */
    public function detail(User $user) : Response
    {
        return new JsonResponse(['code'=> 200, 'username'=> $user->getUsername()], 200);
    }

}
