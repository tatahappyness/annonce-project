<?php

namespace App\Form;

use App\Entity\ModePrix;
use App\Entity\Article;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ModePrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prixTitle')
            ->add('prixDescription')
            ->add('prixImage')
            ->add('prixGlobale')
            ->add('prixMoyen')
            ->add('prixHautGamme')
            ->add('prixDateCrea')
            ->add('prixCategoryId', EntityType::class, [
                'class' => Category::class, 'label' => 'Category',
                'mapped' => false,
                'choice_label' => 'Category',
                'query_builder' => function (EntityRepository $er ){
                    return $er->createQueryBuilder ('c')
                                ->orderBy('c.id', 'ASC');
                }
            ]
        )
        ->add('prixArticleId', EntityType::class, [
            'class' => Article::class, 'label' => 'Article',
            'mapped' => false,
            'choice_label' => 'Article',
            'query_builder' => function (EntityRepository $er ){
                return $er->createQueryBuilder ('a')
                            ->orderBy('a.id', 'ASC') ;
            }
        ]
    )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModePrix::class,
        ]);
    }
}
