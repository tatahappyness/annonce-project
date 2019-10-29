<?php

namespace App\Form;

use App\Entity\Services;
use App\Entity\Category;
use App\Entity\User;
use App\Form\CategoryType;
use App\Form\UserType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isActived')
            ->add('dateCrea')
            ->add('categoryId', EntityType::class, [
                    'class' => Category::class,
                    'mapped' => false,
                    'choice_label' => function (Category $cat){
                        return $cat->getCategTitle();
                    }
                ]

            )     
            ->add('userId', EntityType::class, [
                'class' => User::class,
                'mapped' => false,
                'choice_label' => function (User $user){
                        return $user->getTitle();
                    }
                ]
            )
            
            ;
            


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
