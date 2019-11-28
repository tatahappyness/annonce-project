<?php

namespace App\Controller;

use App\Repository\ConfigsiteRepository;
use App\Entity\ThemeColor;
use App\Form\ThemeColorType;
use App\Repository\ThemeColorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/theme/color")
 */
class ThemeColorController extends AbstractController
{
    /**
     * @Route("/", name="theme_color_index", methods={"GET","POST"})
     */
    public function index(Request $request, ConfigsiteRepository $configsiteRepository, ThemeColorRepository $themeColorRepository): Response
    {
        $themeColor = new ThemeColor();
        $form = $this->createForm(ThemeColorType::class, $themeColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //theme_color[ThemeId]
            $allDataForm = $request->request->get("theme_color");                        
            $themeId =  $allDataForm['ThemeId'];
            
            

            $entityManager = $this->getDoctrine()->getManager();
            
            $theme = $this->getDoctrine()
                ->getRepository(\App\Entity\Theme::class)
                ->findById($themeId);   

            //dump($theme); die;

            $themeColor->setThemeId( $theme );
            
            //dump($themeColor); die;
            

            $entityManager->persist($themeColor);
            $entityManager->flush();

            return $this->redirectToRoute('theme_color_index');
        }

        return $this->render('theme_color/index.html.twig', [
            'theme_colors' => $themeColorRepository->findAll(),
            'page_head_title' => 'Theme Couleur',
            'configsites' => $configsiteRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="theme_color_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $themeColor = new ThemeColor();
        $form = $this->createForm(ThemeColorType::class, $themeColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($themeColor);
            $entityManager->flush();

            return $this->redirectToRoute('theme_color_index');
        }

        return $this->render('theme_color/new.html.twig', [
            'theme_color' => $themeColor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="theme_color_show", methods={"GET"})
     */
    public function show(ThemeColor $themeColor): Response
    {
        return $this->render('theme_color/show.html.twig', [
            'theme_color' => $themeColor,
        ]);
    }

    
    /**
     * @Route("/{id}/delthemecolor", name="delthemecolor", methods={"GET"})
     */
    public function delthemecolor(ThemeColor $themeColor): Response
    {
        return $this->render('theme_color/show_del.html.twig', [
            'theme_color' => $themeColor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="theme_color_edit", methods={"GET","POST"})
     */
    public function edit( ConfigsiteRepository $configsiteRepository, Request $request, ThemeColor $themeColor): Response
    {
        $form = $this->createForm(ThemeColorType::class, $themeColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('theme_color_index', [
                'id' => $themeColor->getId(),
                'page_head_title' => 'Theme Couleur',
                'configsites' => $configsiteRepository->findAll()
            ]);
        }

        return $this->render('theme_color/edit.html.twig', [
            'theme_color' => $themeColor,
            'form' => $form->createView(),
            'page_head_title' => 'Theme Couleur',
            'configsites' => $configsiteRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="theme_color_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ThemeColor $themeColor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$themeColor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($themeColor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('theme_color_index');
    }
}
