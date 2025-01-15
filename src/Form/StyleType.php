<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du style',
                'attr' => [
                    'placeholder' => 'Donnez un nom',
                ]
            ])
            ->add('color', ColorType::class, [
                'label' => 'Choix de la couleur',
                'attr' => [
                    'class' => 'w-100',
                ]
            ])
            /*->add('albums', EntityType::class, [
                'class' => Album::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Style::class,
        ]);
    }
}
