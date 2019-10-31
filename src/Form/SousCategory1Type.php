<?php

namespace App\Form;

use App\Entity\SousCategory;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class SousCategory1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sousCategTitle', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Sous categorie',                              
                'required'    => true
            ))     
            ->add('description', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Description',                              
                'required'    => true
            ))  
            /*
            ->add('sousCategDateCrea')             
            ->add('catSousCategoryId', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Sous Categorie',                              
                'required'    => true
            ))  */
            ->add('catSousCategoryId', EntityType::class, [
                'class' => Category::class, 'label' => 'Categorie',
                'mapped' => false,
                'choice_label' => function (Category $cat){
                    return $cat->getCategTitle();
                },
                'choice_value' => function (Category $cat = null) {
                    return $cat ? $cat->getId() : '';
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
            'data_class' => SousCategory::class,
        ]);
    }
}
