<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Style;
use App\Repository\ArtisteRepository;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'album',
                'attr' => [
                    'placeholder' => 'Saisir le nom de l\'album',
                ]
            ])
            ->add('createdAt', TextType::class, [
                'label' => 'Anne de l\'album',
            ])
            ->add('imageUrl', TextType::class, [
                'label' => 'image',
                'required' => false,
            ])
            ->add('artist', EntityType::class, [
                'label' => 'Nom de l\'artiste',
                'class' => Artiste::class,
                'query_builder' => function (ArtisteRepository $ar) {
                    return $ar->filterListArtist();
                },
                'choice_label' => 'name',
            ])
            ->add('styles', EntityType::class, [
                'label' => 'Style',
                'class' => Style::class,
                'query_builder' => function (StyleRepository $sr) {
                    return $sr->filterListStyle();
                },
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
