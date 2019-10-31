<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categTitle', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Categorie',                              
                'required'    => true
            ))  
            ->add('description', TextType::class, array(                
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Description',                            
                'required'    => false
                
            ))               
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
            'data_class' => Category::class,
        ]);
    }
}
