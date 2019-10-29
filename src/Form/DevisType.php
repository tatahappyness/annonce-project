<?php

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detailProject')
            ->add('firstName')
            ->add('userName')
            ->add('phoneNumber')
            ->add('email')
            ->add('zipCode')
            ->add('isAcceptedCondition')
            ->add('civility')
            ->add('isAskDemande')
            ->add('dateCrea')
            ->add('devisIsAccepted')
            ->add('devisIsValidated')
            ->add('devisIsFinished')
            ->add('devUserId')
            ->add('devUserIdDest')
            ->add('natureProject')
            ->add('fonctionId')
            ->add('typeProject')
            ->add('city')
            ->add('CategoryId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
