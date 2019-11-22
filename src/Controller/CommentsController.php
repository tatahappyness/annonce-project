<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use App\Repository\ConfigsiteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/comments")
 */
class CommentsController extends AbstractController
{
    /**
     * @Route("/", name="comments_index", methods={"GET"})
     */
    public function index(CommentsRepository $commentsRepository, ConfigsiteRepository $configsiteRepository): Response
    {
        return $this->render('comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
            'page_head_title' => 'Publication',
            'configsites' => $configsiteRepository->findAll()
        ]);
    }

    
    /**
     * @Route("/ispopular", name="ispopular", methods={"GET"})
     */
    public function ispopular(Request $req, CommentsRepository $commentsRepository,  ConfigsiteRepository $configsiteRepository ): Response
    {                
        $entityManager = $this->getDoctrine()->getManager();
                                                   
        if ( $req->query->get('active') == 'true' ) {             
                
            try {

                $entityManager->beginTransaction();

                $comment = $commentsRepository->findById( (int) $req->query->get('id') );                
                $comment->setIsPublish(true);

                $entityManager->merge($comment);
                $entityManager->flush();                       
                $entityManager->commit();

                return new Response('Publication activé');
            } catch (\Throwable $th) {
                return new Response('Erreur serveur');
            }
        }
            
        try {

            $entityManager->beginTransaction();

            $comment = $commentsRepository->findById( (int) $req->query->get('id') );            
            $comment->setIsPublish(false);

            $entityManager->merge($comment);
            $entityManager->flush();
            $entityManager->commit();

            
            return new Response('Popularité desactivé');
        } catch (\Throwable $th) {
            return new Response('Erreur serveur');
        }
    }



    /**
     * @Route("/new", name="comments_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comments_index');
        }

        return $this->render('comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comments_show", methods={"GET"})
     */
    public function show(Comments $comment): Response
    {
        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_index', [
                'id' => $comment->getId(),
            ]);
        }

        return $this->render('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comments_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comments_index');
    }
}
