<?php

namespace App\Controller;

use App\Entity\Fonction;
use App\Form\FonctionType;

use App\Repository\FonctionRepository;
use App\Repository\ConfigsiteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fonction")
 */
class FonctionController extends AbstractController
{
    /**
     * @Route("/", name="fonction_index", methods={"GET","POST"})
     */
    public function index(Request $request, ConfigsiteRepository $configsiteRepository, FonctionRepository $fonctionRepository): Response
    {
        $fonction = new Fonction();
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->beginTransaction();
            

            $fonction->setDateCrea(new \DateTime());
            
            $entityManager->persist($fonction);
            $entityManager->flush();
            $entityManager->commit();

            return $this->redirectToRoute('fonction_index');
        }

        return $this->render('fonction/index.html.twig', [
            'fonctions' => $fonctionRepository->findAll(),
            'page_head_title' => 'Fonction',
            'configsites' => $configsiteRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="fonction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fonction = new Fonction();
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fonction);
            $entityManager->flush();

            return $this->redirectToRoute('fonction_index');
        }

        return $this->render('fonction/new.html.twig', [
            'fonction' => $fonction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newFonction", name="newFonction", methods={"GET","POST"})
     */
    public function newFonction(Request $request): Response
    {
        $fonction = new Fonction();
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->beginTransaction();


            $fonction->setDateCrea(new \DateTime());
            dump($fonction);die;
            


            $entityManager->persist($fonction);
            $entityManager->flush();

            $entityManager->commit();

            return $this->redirectToRoute('fonction_index');
        }

        return $this->render('fonction/new.html.twig', [
            'fonction' => $fonction,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="fonction_show", methods={"GET"})
     */
    public function show(Fonction $fonction): Response
    {
        return $this->render('fonction/show.html.twig', [
            'fonction' => $fonction,
        ]);
    }

    /**
     * @Route("/fonctionDelete/{id}", name="fonctionDelete", methods={"GET"})
     */
    public function fonctionDelete(Fonction $fonction): Response
    {
        return $this->render('fonction/show_delete.html.twig', [
            'fonction' => $fonction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fonction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ConfigsiteRepository $configsiteRepository, Fonction $fonction): Response
    {
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fonction->setDateCrea(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fonction_index', [                
                'page_head_title' => 'Fonction',
                'configsites' => $configsiteRepository->findAll(),
                'id' => $fonction->getId(),
            ]);
        }

        return $this->render('fonction/edit.html.twig', [
            'fonction' => $fonction,       
            'page_head_title' => 'Fonction',
            'configsites' => $configsiteRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fonction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fonction $fonction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fonction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fonction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fonction_index');
    }
}
