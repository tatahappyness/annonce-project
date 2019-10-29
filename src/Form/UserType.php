<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('name')
            ->add('mobile')
            ->add('businessCategory')
            ->add('businessSubCategory')
            ->add('companyTitle')
            ->add('isAcceptConditionTerm')
            ->add('isBusiness')
            ->add('isProfessional')
            ->add('logo')
            ->add('profilImage')
            ->add('memberType')
            ->add('isActivity')
            ->add('companyName')
            ->add('username')
            ->add('firstname')
            ->add('enabled')
            ->add('isParticular')
            ->add('siretNumber')
            ->add('zipCode')
            ->add('lat')
            ->add('log')
            ->add('freeDateExpire')
            ->add('firstName')
            ->add('dateCrea')
            ->add('userCategoryActivity')
            ->add('userCity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
