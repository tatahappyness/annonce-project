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


class SousCategory1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sousCategTitle')
            ->add('sousCategDateCrea')
            ->add('description')
            ->add('img')
            ->add('icon')
            
            ->add('catSousCategoryId', EntityType::class, [
                'class' => Category::class, 'label' => 'Categorie',
                'mapped' => false,
                'choice_label' => function (Category $cat){
                    return $cat->getCategTitle();
                }
            ]
        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousCategory::class,
        ]);
    }
}
