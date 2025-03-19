<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'artiste",
                'attr' => [
                    'placeholder' => "Saisir le nom de l'artiste",
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => "Description de l'artiste",
            ])
            ->add('site', UrlType::class, [
                'label' => "Site",
                'default_protocol' => 'https'
            ] )
            ->add('imageUrl', TextType::class, [
                'label' => "Image",
            ])
            ->add('type', ChoiceType::class, [
                'label' => "Type d'artiste",
                "choices" => [
                    "solo" => 0,
                    "groupe" => 1
                ]
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Charger la photo',
                'attr' => [
                    'accept' => '.jpg, .png',
                ],
                'constraints' => [
                    new Image([
                        'maxSize' => '200k',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
