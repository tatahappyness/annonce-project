<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('articleTitle',  TextType::class, ['label' => 'Article'], array ('required' => true, 'attr' => array ('class' => 'form-control' ) ))
            ->add('articleDateCrea', DateType::class, ['label' => 'Date de creation'], array ('required' => true, 'attr' => array ('class' => 'col-md-12' ) ))            
            ->add('articleCategId', EntityType::class, [
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
            'data_class' => Article::class,
        ]);
    }
}

