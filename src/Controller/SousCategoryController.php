<?php

namespace App\Controller;

use App\Entity\SousCategory;
use App\Form\SousCategory1Type;

use App\Repository\SousCategoryRepository;
use App\Repository\ConfigsiteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sous/category")
 */
class SousCategoryController extends AbstractController
{
    /**
     * @Route("/", name="sous_category_index", methods={"GET"})
     */
    public function index(SousCategoryRepository $sousCategoryRepository ,   ConfigsiteRepository $configsiteRepository ): Response
    {
        return $this->render('sous_category/index.html.twig', [
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'OBJET DEVIS [Sous Categorie]',
            'sous_categories' => $sousCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sous_category_new", methods={"GET","POST"})
     */
    public function new(Request $request,    ConfigsiteRepository $configsiteRepository ): Response
    {
        $sousCategory = new SousCategory();
        $form = $this->createForm(SousCategory1Type::class, $sousCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $allDataForm = $request->request->get("sous_category1");                        
            $cat = $allDataForm['catSousCategoryId'];
            

            /** @var File $file */
            $file = $form['img']->getData();            
            
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['icon']->getData();

            if ( $file &&  $fileIcon ) {
                
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\Category::class)
                    ->findById($cat);
                $sousCategory->setCatSousCategoryId($category);



                $output_dir = $this->getParameter('images_directory');      
                $output_dir_icon = $this->getParameter('logo_directory');      
            
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_icon = uniqid().".".$fileIcon->getClientOriginalExtension();

                $file->move($output_dir, $newFilename);
                $fileIcon->move($output_dir_icon, $newFilename_icon);

            
                $sousCategory->setSousCategDateCrea(new \DateTime());
                $sousCategory->setImg($newFilename);
                $sousCategory->setIcon($newFilename_icon);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($sousCategory);
                $entityManager->flush();
                
                return $this->redirectToRoute('sous_category_index');
            }

        }

        return $this->render('sous_category/new.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Sous Categorie]',
            'configsites' => $configsiteRepository->findAll(),
            'sous_category' => $sousCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sous_category_show", methods={"GET"})
     */
    public function show(SousCategory $sousCategory): Response
    {
        return $this->render('sous_category/show_category.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Sous Categorie]',
            'sous_category' => $sousCategory,
        ]);
    }

    
    /**
     * @Route("/{id}/image", name="sous_category_show_image", methods={"GET"})
     */
    public function sous_category_show_image(SousCategory $sousCategory): Response
    {
        return $this->render('sous_category/show_category_image.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Categorie]',
            'sous_category' => $sousCategory
        ]);
    }

    /**
     * @Route("/{id}/icone", name="sous_category_show_icone", methods={"GET"})
     */
    public function sous_category_show_icone(SousCategory $sousCategory): Response
    {
        return $this->render('sous_category/show_category_icon.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Categorie]',
            'sous_category' => $sousCategory
        ]);
    }


    /**
     * @Route("/{id}/edit", name="sous_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SousCategory $sousCategory,   ConfigsiteRepository $configsiteRepository ): Response
    {
        $form = $this->createForm(SousCategory1Type::class, $sousCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                        
            $allDataForm = $request->request->get("sous_category1");                        
            $cat = $allDataForm['catSousCategoryId'];
            
            /** @var File $file */
            $file = $form['img']->getData();            
            
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['icon']->getData();

            if ( $file &&  $fileIcon ) {
                
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\Category::class)
                    ->findById($cat);
                $sousCategory->setCatSousCategoryId($category);

                $output_dir = $this->getParameter('images_directory');      
                $output_dir_icon = $this->getParameter('logo_directory');      
        
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_icon = uniqid().".".$fileIcon->getClientOriginalExtension();

                $file->move($output_dir, $newFilename);
                $fileIcon->move($output_dir_icon, $newFilename_icon);

                $sousCategory->setSousCategDateCrea(new \DateTime());

                $sousCategory->setImg($newFilename);
                $sousCategory->setIcon($newFilename_icon);
                            
                /*
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($category);
                $entityManager->flush();*/

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('sous_category_index', [
                    'configsites' => $configsiteRepository->findAll(),
                    'page_head_title' => 'OBJET DEVIS [Sous Categorie]',
                    'id' => $sousCategory->getId(),
                ]);

            }





        }

        return $this->render('sous_category/edit.html.twig', [
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'OBJET DEVIS [Sous Categorie]',
            'sous_category' => $sousCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sous_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SousCategory $sousCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sousCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sous_category_index');
    }
}
