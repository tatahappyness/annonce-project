<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;

use App\Repository\ConfigsiteRepository;
use App\Repository\ArticleRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository,  ConfigsiteRepository $configsiteRepository ): Response
    {
        return $this->render('article/index.html.twig', [
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'OBJET DEVIS [Article]',
            'articles' => $articleRepository->findAll(),
            
        ]);
    }

    /**
     * @Route("/ispopular", name="ispopular", methods={"GET"})
     */
    public function ispopular(Request $req, ArticleRepository $articleRepository,  ConfigsiteRepository $configsiteRepository ): Response
    {                
        $entityManager = $this->getDoctrine()->getManager();
                                                   
        if ( $req->query->get('active') == 'true' ) {             
                
            try {

                $entityManager->beginTransaction();

                $article = $articleRepository->findById( (int) $req->query->get('id') );                
                $article->setIsPopular(true);

                $entityManager->merge($article);
                $entityManager->flush();                       
                $entityManager->commit();

                return new Response('Popularité activé');
            } catch (\Throwable $th) {
                return new Response('Erreur serveur');
            }
        }
            
        try {

            $entityManager->beginTransaction();

            $article = $articleRepository->findById( (int) $req->query->get('id') );            
            $article->setIsPopular(false);

            $entityManager->merge($article);
            $entityManager->flush();
            $entityManager->commit();

            
            return new Response('Popularité desactivé');
        } catch (\Throwable $th) {
            return new Response('Erreur serveur');
        }
    }


    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, ConfigsiteRepository $configsiteRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            /** @var File $file */
            $file = $form['img']->getData();
            
            
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['icon']->getData();

            if ( $file &&  $fileIcon ) {
                
                $output_dir = $this->getParameter('images_directory');      
                $output_dir_icon = $this->getParameter('logo_directory');      
        


                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_icon = uniqid().".".$fileIcon->getClientOriginalExtension();

                $file->move($output_dir, $newFilename);
                $fileIcon->move($output_dir_icon, $newFilename_icon);

                $article->setArticleDateCrea(new \DateTime());

                $article->setImg($newFilename);
                $article->setIcon($newFilename_icon);

                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();
                                            
                return $this->redirectToRoute('article_index');
            }
        }

        return $this->render('article/new.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Article]',
            'configsites' => $configsiteRepository->findAll(),
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article,  ConfigsiteRepository $configsiteRepository ): Response
    {
        return $this->render('article/show_article.html.twig', [
            'configsites' => $configsiteRepository->findAll(),
            'page_head_title' => 'OBJET DEVIS [Article]',
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article, ConfigsiteRepository $configsiteRepository ): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            
            /** @var File $file */
            $file = $form['img']->getData();
            
            
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['icon']->getData();

            if ( $file &&  $fileIcon ) {
                
                $output_dir = $this->getParameter('images_directory');      
                $output_dir_icon = $this->getParameter('logo_directory');      
        


                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_icon = uniqid().".".$fileIcon->getClientOriginalExtension();

                $file->move($output_dir, $newFilename);
                $fileIcon->move($output_dir_icon, $newFilename_icon);

                $article->setArticleDateCrea(new \DateTime());

                $article->setImg($newFilename);
                $article->setIcon($newFilename_icon);

                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();                                                            

                return $this->redirectToRoute('article_index', [
                    'configsites' => $configsiteRepository->findAll(),
                    'id' => $article->getId(),
                    'page_head_title' => 'OBJET DEVIS [Article]'
                ]);

            }           
        }

        return $this->render('article/edit.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Article]',
            'configsites' => $configsiteRepository->findAll(),
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('objet_devis');
    }
}
