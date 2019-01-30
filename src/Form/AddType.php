<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Category;
use App\Entity\Media;
class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('duration')
            ->add('price')
            ->add('video')
            ->add('status')
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'tag'
            ])
            ->add('media',EntityType::class,[
                'class'=>Media::class,
                'choice_label'=>'image'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
