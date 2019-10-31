<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder        
            ->add('articleTitle', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Article',                              
                'required'    => true
            ))  
            ->add('articleCategId', EntityType::class, [
                'class' => Category::class, 'label' => 'Categorie',
                'mapped' => false,
                'attr' => ['class' => 'form-control col-lg-12'],
                'choice_label' => function (Category $cat){
                        return $cat->getCategTitle();
                    }
                ]
            )
            ->add('img', FileType::class, [
                'label' => 'Image',                
                'attr' => ['class' => 'form-control btn-info col-lg-12'],                  
                'mapped' => false,
                'required'    => true
            ])
            ->add('icon', FileType::class, [
                'label' => 'Icon',    
                'mapped' => false,
                'attr' => ['class' => 'form-control btn-info col-lg-12'],
                'required'    => true
            ])
    
    
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

