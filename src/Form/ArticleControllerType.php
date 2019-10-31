<?php

namespace App\Form;

use App\Entity\SousCategory;
use App\Entity\Category;
use App\Form\CategoryType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ArticleControllerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sousCategTitle')
            ->add('sousCategDateCrea')
            ->add('description')
            ->add('img')
            ->add('icon')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousCategory::class,
        ]);
    }
}
