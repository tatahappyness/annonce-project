<?php

namespace App\Controller;

use App\Entity\ModePrix;
use App\Form\ModePrixType;

use App\Repository\ConfigsiteRepository;
use App\Repository\ModePrixRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mode/prix")
 */
class ModePrixController extends AbstractController
{
    /**
     * @Route("/", name="mode_prix_index", methods={"GET"})
     */
    public function index(ModePrixRepository $modePrixRepository,  ConfigsiteRepository $configsiteRepository ): Response
    {
        return $this->render('mode_prix/index.html.twig', [
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'OBJET DEVIS [Mode Prix]',
            'mode_prixes' => $modePrixRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mode_prix_new", methods={"GET","POST"})
     */
    public function new(Request $request,  ConfigsiteRepository $configsiteRepository ): Response
    {
        $modePrix = new ModePrix();
        
        $form = $this->createForm(ModePrixType::class, $modePrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modePrix);
            $entityManager->flush();

            return $this->redirectToRoute('mode_prix_index');
        }

        return $this->render('mode_prix/new.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Mode Prix]',
            'configsites' => $configsiteRepository->findAll(),
            'mode_prix' => $modePrix,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mode_prix_show", methods={"GET"})
     */
    public function show(ModePrix $modePrix): Response
    {
        return $this->render('mode_prix/show_prix.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Mode Prix]',
            'mode_prix' => $modePrix,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mode_prix_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ModePrix $modePrix,  ConfigsiteRepository $configsiteRepository ): Response
    {
        $form = $this->createForm(ModePrixType::class, $modePrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mode_prix_index', [
                'page_head_title' => 'OBJET DEVIS [Mode Prix]',
                'configsites' => $configsiteRepository->findAll(),
                'id' => $modePrix->getId()
            ]);
        }

        return $this->render('mode_prix/edit.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Mode Prix]',            
            'configsites' => $configsiteRepository->findAll(),
            'mode_prix' => $modePrix,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mode_prix_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ModePrix $modePrix): Response
    {
        if ($this->isCsrfTokenValid('delete'.$modePrix->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($modePrix);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mode_prix_index');
    }
}
