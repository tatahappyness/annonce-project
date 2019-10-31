<?php

namespace App\Form;

use App\Entity\Configsite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConfigsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomsite', TextType::class, array(
                'label' => 'Nom du site ',  
                'attr' => ['class' => 'form-control col-lg-12'],           
                'required'    => true
            ))         
            
            ->add('email', TextType::class, array(
                'label' => 'Email ',              
                'attr' => ['class' => 'form-control col-lg-12'],        
                'required'    => true
            ))         
            
            ->add('numphone', TextType::class, array(
                'label' => 'Numero mobile ',               
                'attr' => ['class' => 'form-control col-lg-12'],
                'required'    => true
            ))         
                        
            //->add('categDateCrea')
            //->add('description')            
            ->add('image', FileType::class, [
                'label' => 'Image ',    
                'mapped' => false,
                'attr' => ['class' => 'form-control btn-info col-lg-12'],  
                'required'    => true
            ])     

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Configsite::class,
        ]);
    }
}
