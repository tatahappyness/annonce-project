<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\SousCategory;
use App\Form\ArticleType;

use App\Repository\ConfigsiteRepository;
use App\Repository\ArticleRepository;
use App\Repository\SousCategoryRepository;

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
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request,SousCategoryRepository $sousCategoryRepository, ConfigsiteRepository $configsiteRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var File $file */
            $file = $form['img']->getData();
            
            
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['icon']->getData();

            $allDataForm = $request->request->get("article");                        
            $sous_cat =  $allDataForm['articleSousCategId'];
            $cat = $allDataForm['articleCategId'];
            
            
           
           
            //$souscategory = $sousCategoryRepository->findById($sous_cat);     
            
            
            if ( $file &&  $fileIcon ) {
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->beginTransaction();                                

                /*
                $souscategory = $this->getDoctrine()
                    ->getRepository(SousCategory::class)
                    ->findById($sous_cat);*/
                                   
                $souscategory = $this->getDoctrine()
                    ->getRepository(\App\Entity\SousCategory::class)
                    ->findById($sous_cat);

                $article->setArticleSousCategId($souscategory);
            
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\Category::class)
                    ->findById($cat);
                $article->setArticleCategId($category);
                //dump($article);die;
                
                $output_dir = $this->getParameter('images_directory');      
                $output_dir_icon = $this->getParameter('logo_directory');      
        
                $newFilename = uniqid().".".$file->getClientOriginalExtension();
                $newFilename_icon = uniqid().".".$fileIcon->getClientOriginalExtension();

                $file->move($output_dir, $newFilename);
                $fileIcon->move($output_dir_icon, $newFilename_icon);

                $article->setArticleDateCrea(new \DateTime());

                $article->setImg($newFilename);
                $article->setIcon($newFilename_icon);                
                                
                $entityManager->persist($article);            
                $entityManager->flush();
                $entityManager->commit();
                                            
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
     * @Route("/delete/{id}", name="deleteArticleShow", methods={"GET"})
     */
    public function deleteArticleShow(Article $article): Response
    {
        return $this->render('article/show_article_delete.html.twig', [            
            'article' => $article
        ]);
    }



    /**
     * @Route("/{id}/image", name="article_show_image", methods={"GET"})
     */
    public function article_show_image(Article $article): Response
    {
        return $this->render('article/show_article_image.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Article]',
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/icone", name="article_show_icone", methods={"GET"})
     */
    public function article_show_icone(Article $article): Response
    {
        return $this->render('article/show_article_icon.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Article]',
            'article' => $article,
        ]);
    }

    

    /**
     * @Route("/pop/{id}/{active}", name="ispop", methods={"GET"})
     */
    public function ispop($id = null , $active = null , ArticleRepository $commentsRepository ,  Article $article): Response
    {

                     
        //dump($active);die;

        $entityManager = $this->getDoctrine()->getManager();
          
        if ( $active == 'true' ) {             
                
            try {

                $entityManager->beginTransaction();

                $comment = $commentsRepository->findById($id);                
                $comment->setIsPopular(true);

                $entityManager->merge($comment);
                $entityManager->flush();                       
                $entityManager->commit();

                return new Response('Populaire activé');
            } catch (\Throwable $th) {
                return new Response('Erreur serveur active');
            }
        }
            
        try {

            $entityManager->beginTransaction();

            $comment = $commentsRepository->findById($id);            
            $comment->setIsPopular(false);

            $entityManager->merge($comment);
            $entityManager->flush();
            $entityManager->commit();

            
            return new Response('Populaire desactivé');
        } catch (\Throwable $th) {
            return new Response('Erreur serveur false');
        }

    }

    
    
    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article, ConfigsiteRepository $configsiteRepository ): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /*
            $allDataForm = $request->request->get("article");                        
            $sous_cat =  $allDataForm['articleSousCategId'];
            $cat = $allDataForm['articleCategId'];
            */
            $allDataForm = $request->request->get("article");                        
            $sous_cat =  $allDataForm['articleSousCategId'];
            $cat = $allDataForm['articleCategId'];
            
            
            
            /** @var File $file */
            $file = $form['img']->getData();
            
            
            /** @var FileIcon $fileIcon */
            $fileIcon = $form['icon']->getData();

            if ( $file &&  $fileIcon ) {
                
                
                $category = $this->getDoctrine()
                    ->getRepository(\App\Entity\Category::class)
                    ->findById($cat);
                $article->setArticleCategId($category);
                
                
                
                $souscategory = $this->getDoctrine()
                    ->getRepository(\App\Entity\SousCategory::class)
                    ->findById($sous_cat);
                $article->setArticleSousCategId($souscategory);
                
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

        return $this->redirectToRoute('article_index');
    }
}
