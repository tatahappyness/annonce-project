<?php

namespace App\Form;

use App\Entity\ThemeColor;
use App\Entity\Theme;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ThemeColorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Color', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Couleur',                              
                'required'    => true
            ))          
            
            ->add('KeyWord', TextType::class, array(
                'attr' => ['class' => 'form-control col-lg-12'],
                'label' => 'Mot clé',                              
                'required'    => true
            ))        
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
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ThemeColor::class,
        ]);
    }
}
