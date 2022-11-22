<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('abstract')
            ->add('content')
            ->add('image', FileType::class,[
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize'=> '1024k',
                            'mimeTypes'=>[
                                'image/jpeg',
                                'image/png',
                                'image/svg+xml'
                            ]

                        ]

                    )


                ]

            ])
            ->add('idCategory', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'libCategory',
                'multiple' => true

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
