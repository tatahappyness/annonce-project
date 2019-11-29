<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConfigsiteRepository;

/**
 * @Route("/admin/theme")
 */
class ThemeController extends AbstractController
{
    /**
     * @Route("/", name="theme_index", methods={"GET","POST"})
     */
    public function index(Request $request, ConfigsiteRepository $configsiteRepository, ThemeRepository $themeRepository): Response
    {
        
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var File $file */
            $file = $form['ImageFond']->getData();
              
            if ( $file  ) {
                
                $output_dir = $this->getParameter('themes_directory');                      
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                
                $file->move($output_dir, $newFilename);


                $theme->setImageFond($newFilename);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($theme);
                $entityManager->flush();

                return $this->render('theme/index.html.twig', [
                    'themes' => $themeRepository->findAll(),
                    'page_head_title' => 'Theme',
                    'configsites' => $configsiteRepository->findAll()
                ]);
            }
        }

        return $this->render('theme/index.html.twig', [
            'themes' => $themeRepository->findAll(),
            'page_head_title' => 'Theme',
            'configsites' => $configsiteRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="theme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var File $file */
            $file = $form['ImageFond']->getData();
            $file_capture = $form['ImageCapture']->getData();
              
            if ( $file && $file_capture ) {
                
                $output_dir = $this->getParameter('themes_directory');                      
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_capture = uniqid().".".$file->getClientOriginalExtension();
                
                $file->move($output_dir, $newFilename);
                $file_capture->move($output_dir, $newFilename);


                //dump(file_capture); die;
                $theme->setImageFond($newFilename);
                $theme->setImageCapture($newFilename_capture);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($theme);
                $entityManager->flush();

                return $this->redirectToRoute('theme_index');
            }
        }

        return $this->render('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="theme_show", methods={"GET"})
     */
    public function show(Theme $theme): Response
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
        ]);
    }

    
    
    /**
     * @Route("/{id}/deletetheme", name="deletetheme", methods={"GET"})
     */
    public function deletetheme(Theme $theme): Response
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
        ]);
    }


    
    /**
     * @Route("/{id}/image", name="theme_show_image", methods={"GET"})
     */
    public function theme_show_image(Theme $theme): Response
    {
        return $this->render('theme/show_image.html.twig', [
            'theme' => $theme,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="theme_edit", methods={"GET","POST"})
     */
    public function edit(ConfigsiteRepository $configsiteRepository, Request $request, Theme $theme): Response
    {
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var File $file */
            $file = $form['ImageFond']->getData();
            $file_capture = $form['ImageCapture']->getData();

            if ( $file && $file_capture ) {
                
                $output_dir = $this->getParameter('themes_directory');                      
                $output_dir_2 = $this->getParameter('themes_directory');                      
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_capture = uniqid().".".$file->getClientOriginalExtension();
                
                $file->move($output_dir, $newFilename);
                $file_capture->move($output_dir_2, $newFilename_capture);


                $theme->setImageFond($newFilename);
                $theme->setImageCapture($newFilename_capture);

                //dump($theme); die;

                //dump(file_capture); die;
                

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($theme);
                $entityManager->flush();
                //$this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('theme_index', [
                    'id' => $theme->getId(),
                    'page_head_title' => 'Theme',
                    'configsites' => $configsiteRepository->findAll()
                ]);
            }
        }

        return $this->render('theme/edit.html.twig', [
            'theme' => $theme,
            'page_head_title' => 'Theme',
            'configsites' => $configsiteRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="theme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Theme $theme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$theme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($theme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('theme_index');
    }
}
