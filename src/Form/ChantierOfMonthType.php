<?php

namespace App\Form;

use App\Entity\ChantierOfMonth;
use App\Entity\Article;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ChantierOfMonthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Déscription',                              
                'required'    => true
            ))  
                    
            ->add('categoryId', EntityType::class, [
                'class' => Category::class, 'label' => 'Categorie',
                'attr' => ['class' => 'form-control col-lg-12'],
                'mapped' => false,
                'choice_label' => function (Category $cat){
                        return $cat->getCategTitle();
                    }
                ]
                
            )
            
            ->add('articleId', EntityType::class, [
                'class' => Article::class, 'label' => 'Article',
                'mapped' => false,
                'attr' => ['class' => 'form-control col-lg-12'],
                'choice_label' => function (Article $cat){
                    return $cat->getArticleTitle();
                },
                'choice_value' => function (Article $cat = null) {
                    return $cat ? $cat->getId() : '';
                    }
                ]
            )
            
            
            ->add('imageBefor', FileType::class, [
                'label' => 'Image Avant',                
                'attr' => ['class' => 'form-control btn-info col-lg-12'],                  
                'mapped' => false,
                'required'    => true
            ])
            
            
            ->add('imageAfter', FileType::class, [
                'label' => 'Image Avant',
                'attr' => ['class' => 'form-control btn-info col-lg-12'],                  
                'mapped' => false,
                'required' => true
            ])
                
            //->add('dateCrea')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChantierOfMonth::class,
        ]);
    }
}
