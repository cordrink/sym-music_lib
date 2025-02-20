<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Style;
use App\Repository\ArtisteRepository;
use App\Repository\StyleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

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
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Charger la pochette',
                'attr' => [
                    'accept' => '.jpg, .png',
                ],
                'constraints' => [
                    new Image([
                        'maxSize' => '4k',
                        'maxSizeMessage' => "La taille maximu doit etre de 4ko",
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ]
                    ])
                ],
                'row_attr' => [
                    'class' => 'd-none ',
                ]
            ])
            ->add('imageUrl', HiddenType::class)
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
                'attr' => [
                    'class' => 'custom-select',
                ]
            ])
            ->add('pieces', CollectionType::class, [
                'entry_type' => PieceType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
