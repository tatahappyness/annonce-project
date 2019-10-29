<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="type_index", methods={"GET"})
     */
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->render('type/index.html.twig', [
            'types' => $typeRepository->findAll(),
            'page_head_title' => 'OBJET DEVIS [Type]'
        ]);
    }

    /**
     * @Route("/new", name="type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            		
			
            $type->setDateCrea(null);            
            $type->setDateCrea(new \Datetime());
            
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('type_index');
        }

        return $this->render('type/new.html.twig', [
            
            'page_head_title' => 'OBJET DEVIS [Type]',
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_show", methods={"GET"})
     */
    public function show(Type $type): Response
    {
        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Type $type): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_index', [
                'page_head_title' => 'OBJET DEVIS [Type]',
                'id' => $type->getId(),
            ]);
        }

        return $this->render('type/edit.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Type]',
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Type $type): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_index');
    }
}
