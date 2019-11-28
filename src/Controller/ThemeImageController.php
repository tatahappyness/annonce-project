<?php

namespace App\Controller;

use App\Entity\ThemeImage;
use App\Entity\Theme;
use App\Repository\ConfigsiteRepository;

use App\Repository\ThemeRepository;
use App\Form\ThemeImageType;
use App\Repository\ThemeImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/themeimage")
 */
class ThemeImageController extends AbstractController
{
    /**
     * @Route("/", name="theme_image_index", methods={"GET", "POST"})
     */
    public function index(Request $request,  ConfigsiteRepository $configsiteRepository, ThemeImageRepository $themeImageRepository ): Response
    {
        $themeImage = new ThemeImage();
        $form = $this->createForm(ThemeImageType::class, $themeImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var File $file */
            $allDataForm = $request->request->get("theme_image");
            $themeId =  $allDataForm['ThemeId'];
            
            /** @var File $file */
            $file = $form['Image']->getData();
              
              
            if ( $file  ) {
                
                $output_dir = $this->getParameter('themes_directory');                      
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                
                $file->move($output_dir, $newFilename);
                $themeImage->setImage($newFilename);

                $entityManager = $this->getDoctrine()->getManager();
                //dump($themeImage); die;

                $entityManager->beginTransaction();

                $entityManager->commit();
                $entityManager->persist($themeImage);
                $entityManager->flush();

                return $this->redirectToRoute('theme_image_index');
            }
        }
        return $this->render('theme_image/index.html.twig', [
            'theme_images' => $themeImageRepository->findAll(),     
            
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'Theme Image',
            
        ]);
    }

    /**
     * @Route("/new", name="theme_image_new", methods={"GET","POST"})
     */
    public function new(Request $request,  ThemeRepository $themeRepository): Response
    {
        $themeImage = new ThemeImage();
        $form = $this->createForm(ThemeImageType::class, $themeImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var File $file */
            $allDataForm = $request->request->get("theme_image");
            $themeId =  $allDataForm['ThemeId'];
            
            /** @var File $file */
            $file = $form['Image']->getData();
              
              
            if ( $file  ) {
                
                $output_dir = $this->getParameter('themes_directory');                      
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                
                $file->move($output_dir, $newFilename);
                $themeImage->setImage($newFilename);

                $entityManager = $this->getDoctrine()->getManager();
                //dump($themeImage); die;

                $entityManager->beginTransaction();

                $entityManager->commit();
                $entityManager->persist($themeImage);
                $entityManager->flush();

                return $this->redirectToRoute('theme_image_index');
            }
        }

        return $this->render('theme_image/new.html.twig', [
            'theme_image' => $themeImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="theme_image_show", methods={"GET"})
     */
    public function show(ThemeImage $themeImage): Response
    {
        return $this->render('theme_image/show_delete.html.twig', [
            'theme_image' => $themeImage,
        ]);
    }

    

    /**
     * @Route("/{id}/edit", name="theme_image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ConfigsiteRepository $configsiteRepository,  ThemeImage $themeImage): Response
    {
        $form = $this->createForm(ThemeImageType::class, $themeImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var File $file */
            $allDataForm = $request->request->get("theme_image");                        
            $themeId =  $allDataForm['ThemeId'];
            
            /** @var File $file */
            $file = $form['Image']->getData();
              
              
            if ( $file  ) {
                
                $output_dir = $this->getParameter('themes_directory');
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                
                $file->move($output_dir, $newFilename);


                $themeImage->setImage($newFilename);

                    
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('theme_image_index', [
                    'id' => $themeImage->getId(),
                ]);
            }
        }

        return $this->render('theme_image/edit.html.twig', [
            'theme_image' => $themeImage,
            'form' => $form->createView(),
            'page_head_title' => 'Theme Image',
            'configsites' => $configsiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="theme_image_delete", methods={"DELETE"})
     */
    public function delete(int $id,  Request $request, ThemeImage $themeImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$themeImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
                                
            
            
            $output_dir = $this->getParameter('themes_directory'); 

            $myFile = $output_dir; //+"/"+$themeImage->getImage()+"";

            $nom_image = $themeImage->getImage();

            $src =  "C:\Bitnami\wampstack-7.2.23-0\apache2\htdocs\annonce-project/public/uploads/themes/5ddb94f256b2f.PNG";

            unlink($path . 'PNG');
            //unlink("C:\Bitnami\wampstack-7.2.23-0\apache2\htdocs\annonce-project/public/uploads/themes/5ddb94f256b2f.PNG");

            //dump($nom_image); die;

            $entityManager->remove($themeImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('theme_image_index');
    }
    
    
}
