<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Style;
use App\Model\FilterAlbum;
use App\Repository\ArtisteRepository;
use App\Repository\StyleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreAlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Recherche album',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisir une partie du nom de l\'album recherche',
                ],
            ])
            ->add('artist', EntityType::class, [
                'label' => 'Nom de l\'artiste',
                'class' => Artiste::class,
                'query_builder' => function (ArtisteRepository $ar) {
                    return $ar->filterListArtist();
                },
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('styles', EntityType::class, [
                'label' => 'Style',
                'class' => Style::class,
                'query_builder' => function (StyleRepository $sr) {
                    return $sr->filterListStyle();
                },
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'custom-select',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method' => 'GET',
            'csrf_protection' => false,
            'data_class' => FilterAlbum::class,
        ]);
    }
}
