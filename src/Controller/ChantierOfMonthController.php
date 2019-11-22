<?php

namespace App\Controller;

use App\Entity\ChantierOfMonth;
use App\Form\ChantierOfMonthType;


use App\Repository\ConfigsiteRepository;
use App\Repository\ChantierOfMonthRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/chantier/of/month")
 */
class ChantierOfMonthController extends AbstractController
{
    /**
     * @Route("/", name="chantier_of_month_index", methods={"GET"})
     */
    public function index(ConfigsiteRepository $configsiteRepository , ChantierOfMonthRepository $chantierOfMonthRepository): Response
    {
        return $this->render('chantier_of_month/index.html.twig', [
            'chantier_of_months' => $chantierOfMonthRepository->findAll(),            
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'CHANTIER / MOIS'
        ]);
    }

    /**
     * @Route("/new", name="chantier_of_month_new", methods={"GET","POST"})
     */
    public function new( ConfigsiteRepository $configsiteRepository ,Request $request): Response
    {
        $chantierOfMonth = new ChantierOfMonth();
        $form = $this->createForm(chantierOfMonthType::class, $chantierOfMonth);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$request->request->get($form->getCategoryId());
            //dump($request->request->get("chantier_of_month[categoryId]")); die;

            
            //$request->request->get($form->getCategoryId());
            //dump($request->request->get("chantier_of_month[]")); die;
            //dump($allDataForm['categoryId']);die;
            
            $allDataForm = $request->request->get("chantier_of_month");                        
            $art =  $allDataForm['articleId'];
            $cat = $allDataForm['categoryId'];
            
            
            /** @var File $file */
            $file = $form['imageBefor']->getData();
            
            
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['imageAfter']->getData();

            if ( $file &&  $fileIcon ) {
                

                $output_dir = $this->getParameter('images_directory');      
                $output_dir_icon = $this->getParameter('images_directory');      

                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_icon = uniqid().".".$fileIcon->getClientOriginalExtension();

                $file->move($output_dir, $newFilename);
                $fileIcon->move($output_dir_icon, $newFilename_icon);

                $chantierOfMonth->setDateCrea(new \DateTime());

                $chantierOfMonth->setImageBefor($newFilename);
                $chantierOfMonth->setImageAfter($newFilename_icon);

                

                //$chantierOfMonth->setImageAfter($newFilename_icon);
                
                $article = $this->getDoctrine()
                    ->getRepository(\App\Entity\Article::class)
                    ->findById($art);
                $chantierOfMonth->setArticleId($article);
                
                
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\Category::class)
                    ->findById($cat);
                $chantierOfMonth->setCategoryId($category);

            
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($chantierOfMonth);
                $entityManager->flush();

                return $this->redirectToRoute('chantier_of_month_index');
            }
        }

        return $this->render('chantier_of_month/new.html.twig', [
            'chantier_of_month' => $chantierOfMonth,
            'form' => $form->createView(),
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'CHANTIER / MOIS'
        ]);
    }

    /**
     * @Route("/{id}", name="chantier_of_month_show", methods={"GET"})
     */
    public function show(ChantierOfMonth $chantierOfMonth): Response
    {
        return $this->render('chantier_of_month/show.html.twig', [
            'chantier_of_month' => $chantierOfMonth,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chantier_of_month_edit", methods={"GET","POST"})
     */
    public function edit(ConfigsiteRepository $configsiteRepository , Request $request, ChantierOfMonth $chantierOfMonth): Response
    {
        $form = $this->createForm(ChantierOfMonthType::class, $chantierOfMonth);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $allDataForm = $request->request->get("chantier_of_month");                        
            $art =  $allDataForm['articleId'];
            $cat = $allDataForm['categoryId'];
            
            
            /** @var File $file */
            $file = $form['imageBefor']->getData();
                        
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['imageAfter']->getData();


            if ( $file &&  $fileIcon ) {          
                
                $output_dir = $this->getParameter('images_directory');      
                $output_dir_icon = $this->getParameter('images_directory');      

                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_icon = uniqid().".".$fileIcon->getClientOriginalExtension();

                $file->move($output_dir, $newFilename);
                $fileIcon->move($output_dir_icon, $newFilename_icon);

                $chantierOfMonth->setDateCrea(new \DateTime());

                $chantierOfMonth->setImageBefor($newFilename);
                $chantierOfMonth->setImageAfter($newFilename_icon);

                $article = $this->getDoctrine()
                    ->getRepository(\App\Entity\Article::class)
                    ->findById($art);
                $chantierOfMonth->setArticleId($article);
                
                
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\Category::class)
                    ->findById($cat);
                $chantierOfMonth->setCategoryId($category);

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('chantier_of_month_index', [
                    'id' => $chantierOfMonth->getId(),      
                    'configsites' => $configsiteRepository->findAll(),
                    'page_head_title' => 'CHANTIER / MOIS'
                ]);
            }
        }

        return $this->render('chantier_of_month/edit.html.twig', [
            'chantier_of_month' => $chantierOfMonth,
            'form' => $form->createView(),
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'CHANTIER / MOIS'
        ]);
    }

    /**
     * @Route("/{id}", name="chantier_of_month_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ChantierOfMonth $chantierOfMonth): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chantierOfMonth->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chantierOfMonth);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chantier_of_month_index');
    }
}
