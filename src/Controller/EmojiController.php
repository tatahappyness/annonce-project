<?php

namespace App\Controller;

use App\Entity\Emoji;
use App\Form\EmojiType;

use App\Repository\ConfigsiteRepository;
use App\Repository\EmojiRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/emoji")
 */
class EmojiController extends AbstractController
{
    /**
     * @Route("/", name="emoji_index", methods={"GET"})
     */
    public function index(ConfigsiteRepository $configsiteRepository, EmojiRepository $emojiRepository): Response
    {
        return $this->render('emoji/index.html.twig', [
            'emoji' => $emojiRepository->findAll(),
            'page_head_title' => 'Emoji',
            'configsites' => $configsiteRepository->findAll()

        ]);
    }

    /**
     * @Route("/new", name="emoji_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emoji = new Emoji();
        $form = $this->createForm(EmojiType::class, $emoji);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emoji);
            $entityManager->flush();

            return $this->redirectToRoute('emoji_index');
        }

        return $this->render('emoji/new.html.twig', [
            'emoji' => $emoji,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="emoji_show", methods={"GET"})
     */
    public function show(Emoji $emoji): Response
    {
        return $this->render('emoji/show.html.twig', [
            'emoji' => $emoji,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="emoji_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,ConfigsiteRepository $configsiteRepository, Emoji $emoji): Response
    {
        $form = $this->createForm(EmojiType::class, $emoji);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('emoji_index', [
                'id' => $emoji->getId(),
            ]);
        }

        return $this->render('emoji/edit.html.twig', [
            'emoji' => $emoji,
            'page_head_title' => 'Emoji',
            'configsites' => $configsiteRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="emoji_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Emoji $emoji): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emoji->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emoji);
            $entityManager->flush();
        }

        return $this->redirectToRoute('emoji_index');
    }
}
