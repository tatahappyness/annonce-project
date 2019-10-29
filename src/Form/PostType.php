<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('postLocation')
            ->add('postZipcode')
            ->add('postRegion')
            ->add('postLatitude')
            ->add('postLongitude')
            ->add('postAdsTravauxDescription')
            ->add('postAdsDateCrea')
            ->add('postAdsTypeClient')
            ->add('postAdsTypeHabitation')
            ->add('postAdsStartDate')
            ->add('postAdsTravauxSurface')
            ->add('postAdsEtatTerrain')
            ->add('email')
            ->add('phone')
            ->add('postUserId')
            ->add('typeId')
            ->add('CategoryId')
            ->add('city')
            ->add('articleId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
