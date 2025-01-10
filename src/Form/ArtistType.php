<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('content', TextareaType::class)
            ->add('site', UrlType::class, [
                'default_protocol' => 'https'
            ] )
            ->add('imageUrl', TextType::class)
            ->add('type', ChoiceType::class, [
                "choices" => [
                    "solo" => 0,
                    "groupe" => 1
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
