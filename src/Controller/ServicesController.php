<?php

namespace App\Controller;

use App\Entity\Services;
use App\Entity\User;
use App\Entity\Article;
use App\Form\ServicesType;
use App\Form\Category;

use App\Repository\ServicesRepository;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;

/**
 * @Route("/services")
 */
class ServicesController extends AbstractController
{
    /**
     * @Route("/", name="services_index", methods={"GET"})
     */
    public function index(ServicesRepository $servicesRepository): Response
    {
        return $this->render('services/index.html.twig', [
            'services' => $servicesRepository->findAll(),
        ]);
    }


    /**
     * @Route("/debloque", name="debloque", methods={"GET"})
     */
    public function debloque(ServicesRepository $servicesRepository,  UserRepository $user_rep, CategoryRepository $cat_rep)
    {
        
            $user = $user_rep->findOneById(1);
            $category = $cat_rep->findOneById(9);
            
            $em =  $this->getDoctrine()->getManager();
            
                $em->beginTransaction();

                $services = new Services();
                
                $services->getId(3);
                $services->setUserId($user);
                $services->setCategoryId( $category);
                $services->setIsActived(1);
                $services->setDateCrea(new \DateTime('now'));

                $em->persist($services);
                $em->flush();
                $em->commit();
            
                
           // }
            return $this->redirectToRoute('services_index');
                
    }


    /**
     * @Route("/new", name="services_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $service = new Services();
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('services_index');
        }

        return $this->render('services/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="services_show", methods={"GET"})
     */
    public function show(Services $service): Response
    {
        return $this->render('services/show.html.twig', [
            'service' => $service,
        ]);
    }

     /**
     * @Route("/simple/{id}", name="services_show_simple", methods={"GET"})
     */
    public function show_simple(Services $service): Response
    {
        return $this->render('services/show_simple.html.twig', [
            'service' => $service,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="services_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Services $service): Response
    {
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('services_index', [
                'id' => $service->getId(),
            ]);
        }

        return $this->render('services/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="services_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Services $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service');
    }

    
    /**
     * @Route("/{id}", name="services_update", methods={"GET"})
     */
    public function services_update(Request $request, Services $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->update($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service');
    }


}
