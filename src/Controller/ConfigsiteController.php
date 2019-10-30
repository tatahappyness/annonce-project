<?php

namespace App\Controller;

use App\Entity\Configsite;
use App\Form\ConfigsiteType;
use App\Repository\ConfigsiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/configsite")
 */
class ConfigsiteController extends AbstractController
{
    /**
     * @Route("/", name="configsite_index", methods={"GET"})
     */
    public function index(ConfigsiteRepository $configsiteRepository): Response
    {
        return $this->render('configsite/index.html.twig', [
            
            'page_head_title' => 'CONFIGURATION DU SITE',
            'configsites' => $configsiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="configsite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $configsite = new Configsite();
        $form = $this->createForm(ConfigsiteType::class, $configsite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($configsite);
            $entityManager->flush();

            return $this->redirectToRoute('configsite_index');
        }

        return $this->render('configsite/new.html.twig', [
            
            'page_head_title' => 'CONFIGURATION DU SITE',
            'configsite' => $configsite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="configsite_show", methods={"GET"})
     */
    public function show(Configsite $configsite): Response
    {
        return $this->render('configsite/show.html.twig', [
            
            'page_head_title' => 'CONFIGURATION DU SITE',
            'configsite' => $configsite,
        ]);
    }
    

    /**
     * @Route("/{id}/edit", name="configsite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Configsite $configsite, ConfigsiteRepository $configsiteRepository): Response
    { 
        

        $form = $this->createForm(ConfigsiteType::class, $configsite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var File $file */
            $file = $form['image']->getData();
            

            if ( $file ) {
                
                $output_dir = $this->getParameter('logo_directory');      

        
                $newFilename = uniqid().".".$file->getClientOriginalExtension();


                $file->move($output_dir, $newFilename);


                //$configsite->setCategDateCrea(new \DateTime('now'));
                $configsite->setImage($newFilename);

                            
                /*
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($category);
                $entityManager->flush();*/

            
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('configsite_index', [
                    'id' => $configsite->getId(),   'configsites' => $configsiteRepository->findAll(),
                    'page_head_title' => 'CONFIGURATION DU SITE',
                ]);
            }
        }

        return $this->render('configsite/edit.html.twig', [
            'page_head_title' => 'CONFIGURATION DU SITE', 'configsites' => $configsiteRepository->findAll(),
            'configsite' => $configsite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="configsite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Configsite $configsite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$configsite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($configsite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('configsite_index');
    }
}
