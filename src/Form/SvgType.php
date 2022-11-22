<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SvgType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taille', RangeType::class, [
                'label' => 'Taille',
                'attr' => [
                    'min' => 5,
                    'max' => 50
                ],

            ])
            ->add('couleur', RangeType::class, [
                'label' => 'Couleur',
                'attr' => [
                    'min' => 5,
                    'max' => 50
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
