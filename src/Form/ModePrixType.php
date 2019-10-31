<?php

namespace App\Form;

use App\Entity\ModePrix;
use App\Entity\Article;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ModePrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prixTitle', TextType::class, array(
                'label' => 'Nom',  
                'attr' => ['class' => 'form-control col-lg-12'],           
                'required'    => true
            ))    
            ->add('prixDescription', TextType::class, array(
                'label' => 'Description',  
                'attr' => ['class' => 'form-control col-lg-12'],           
                'required'    => false
            ))         

            
            ->add('prixGlobale', TextType::class, array(
                'label' => 'Prix globale',  
                'attr' => ['class' => 'form-control col-lg-12'],           
                'required'    => true
            ))         
            
            ->add('prixMoyen', TextType::class, array(
                'label' => 'Prix moyen',  
                'attr' => ['class' => 'form-control col-lg-12'],           
                'required'    => false
            ))         
            
            ->add('prixHautGamme', TextType::class, array(
                'label' => 'Prix haute gamme',  
                'attr' => ['class' => 'form-control col-lg-12'],           
                'required'    => false
            ))         
            
            ->add('prixImage', FileType::class, [
                'label' => 'Image',                
                'attr' => ['class' => 'form-control btn-info col-lg-12'],                  
                'mapped' => false,
                'required'    => true
            ])
            

           /* ->add('prixCategoryId', EntityType::class, [
                'class' => Category::class, 'label' => 'Category',
                'mapped' => false,
                'choice_label' => 'Category',
                'query_builder' => function (EntityRepository $er ){
                    return $er->createQueryBuilder ('c');
                }
            ]
        )*/
        /*
        ->add('prixArticleId', EntityType::class, [
            'class' => Article::class, 'label' => 'Article',
            'mapped' => false,
            'choice_label' => 'Article',
            'query_builder' => function (EntityRepository $er ){
                return $er->createQueryBuilder ('a')
                            ->orderBy('a.id', 'ASC') ;
                }
            ]
        )
        */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModePrix::class,
        ]);
    }
}
