<?php

namespace App\Form;

use App\Entity\ThemeImage;
use App\Entity\Theme;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ThemeImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            /*
            ->add('Image', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Couleur',                              
                'required'    => true
            ))          
            */
            ->add('Comments', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Commentaire',                              
                'required'    => true
            ))          

            
            ->add('ThemeId', EntityType::class, [
                'class' => Theme::class, 'label' => 'Theme',
                'mapped' => false,
                'attr' => ['class' => 'form-control col-lg-12'],
                'choice_label' => function (Theme $cat){
                        return $cat->getComments();
                    }
                ]
            )

            
            ->add('Image', FileType::class, [
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
            'data_class' => ThemeImage::class,
        ]);
    }
}
