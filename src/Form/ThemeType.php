<?php

namespace App\Form;

use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('ColorFond', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Couleur du Fond',                              
                'required'    => true
            ))          
            
            ->add('Comments', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Commentaire',                              
                'required'    => true
            ))          
               
            
            ->add('KeyWord', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Mot clé',                              
                'required'    => true
            ))          
            
            ->add('ImageCapture', FileType::class, [
                'label' => 'Image Capture',                     
                'attr' => ['class' => 'form-control btn-info col-lg-12'],                  
                'mapped' => false,
                'required'    => true
            ])

            ->add('ImageFond', FileType::class, [
                'label' => 'Image du Fond',                     
                'attr' => ['class' => 'form-control btn-info col-lg-12'],                  
                'mapped' => false,
                'required'    => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Theme::class,
        ]);
    }
}
