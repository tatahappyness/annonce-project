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
 * @Route("/admin/mode/prix")
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
            
            
            $allDataForm = $request->request->get("mode_prix");                        

            $souscat =  $allDataForm['prixSousCategoryId'];
            $art = $allDataForm['prixArticleId'];
            

            /** @var File $file */
            $file = $form['prixImage']->getData();
            
            if ( $file ) {
                
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\SousCategory::class)
                    ->findById($souscat);
                $modePrix->setPrixSousCategoryId($category);

                $article = $this->getDoctrine()
                    ->getRepository(\App\Entity\Article::class)
                    ->findById($art);
                $modePrix->setPrixArticleId($article);
                
                
            
                $output_dir = $this->getParameter('images_directory');      
                       
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
             
                
                $file->move($output_dir, $newFilename);
                
                $modePrix->SetPrixDateCrea(new \DateTime());

                $modePrix->SetPrixImage($newFilename);
                
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($modePrix);
                $entityManager->flush();
    
                return $this->redirectToRoute('mode_prix_index');

            }
        
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
     * @Route("/{id}/image", name="mode_prix_show_image", methods={"GET"})
     */
    public function mode_prix_show_image(ModePrix $modePrix): Response
    {
        return $this->render('mode_prix/show_mode_prix_image.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Article]',
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
            
            /** @var File $file */
            $file = $form['prixImage']->getData();
            
            $allDataForm = $request->request->get("mode_prix");                        

            $souscat =  $allDataForm['prixSousCategoryId'];
            $art = $allDataForm['prixArticleId'];
            

            if ( $file ) {
                
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\SousCategory::class)
                    ->findById($souscat);
                $modePrix->setPrixSousCategoryId($category);

                $article = $this->getDoctrine()
                    ->getRepository(\App\Entity\Article::class)
                    ->findById($art);
                $modePrix->setPrixArticleId($article);
                
                
                $output_dir = $this->getParameter('images_directory');                      
                $newFilename = uniqid().".".$file->getClientOriginalExtension();                
                $file->move($output_dir, $newFilename);                
                $modePrix->SetPrixDateCrea(new \DateTime());
                $modePrix->SetPrixImage($newFilename);
            
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('mode_prix_index', [
                    'page_head_title' => 'OBJET DEVIS [Mode Prix]',
                    'configsites' => $configsiteRepository->findAll(),
                    'id' => $modePrix->getId()
                ]);

            }

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
