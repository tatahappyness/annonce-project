<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\DevisFinishRepository;
use App\Repository\DevisValidRepository;
use App\Repository\DevisAcceptRepository;
use App\Repository\ServicesRepository;
use App\Repository\PostRepository;
use App\Repository\DevisRepository;
use App\Repository\CitiesRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Categorie]',
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    
    /**
    * @Route("/setImage", name="setImage")
    */
    public function setImage(Request $request, Security $security,  ValidatorInterface $validator )
    {
            $file = $request->files->get('fileImagesCategory');
        
            $violations = $validator->validate(
                $file,
                new File([
                    'maxSize' => '5M'
                ])

            );

                
            if ($violations->count() > 0) {
                return new JsonResponse(array('code'=> 401, 'infos'=> $violations ), 401);         
            }



            $output_dir = $this->getParameter('images_directory');
            $arr_extensions = ["jpg", "jpeg", "jpg", "png", "gif"];


            //@Assert\File(maxSize="6000000")

            if (!(in_array($file->getClientOriginalExtension(), $arr_extensions))) 
            {
                return new JsonResponse(array('code'=> 401, 'infos'=> 'Type de fichier n\'est pas autorisé'), 401);
            }

            
            // generate a random name for the file but keep the extension
            $filename = uniqid().".".$file->getClientOriginalExtension();
            $file->move( $output_dir, $filename); // move the file to a path

            // $request->query->get("image_nature_title")
            // Convert to base64 
            // $video_base64 = base64_encode(file_get_contents($file) );
            // $image = 'data:image/'.$file->getClientOriginalExtension().';base64,'.$image_base64;
           
           
            /*
            try {

                $em = $this->getDoctrine()->getManager();
                $em->beginTransaction();
                // generate a random name for the file but keep the extension
                $filename = uniqid().".".$file->getClientOriginalExtension();
                $file->move( $output_dir, $filename); // move the file to a path

                $article = $articleRep->findById((int) $articleId);
                
                $image = new Images();
                $image
                    ->setUserId($security->getUser())
                    ->setArticleTitle($article)
                    ->setName($filename)
                    ->setDateCrea(new \DateTime('now'));

                $em->persist($image);
                $em->flush();
                $em->commit();
                return new JsonResponse(array('code'=> 200, 'infos'=>  $filename), 200);

            } catch (\Exception $e) {
                return new JsonResponse(['code'=> 500 ,'infos' => $e->getMessage()], 500);
            }*/
            
            return new JsonResponse(array('code'=> 200, 'infos'=>  $filename), 200);
    }


    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        $file = $form['img']->getData();
        
        if ($form->isSubmitted() && $form->isValid()) {

            $file->move($output_dir, $someNewFilename);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Categorie]',
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show_category.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Categorie]',
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index', [
                'page_head_title' => 'OBJET DEVIS [Categorie]',
                'id' => $category->getId(),
            ]);
        }

        return $this->render('category/edit.html.twig', [
            'page_head_title' => 'OBJET DEVIS [Categorie]',
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }
}