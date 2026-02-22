<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Entrez le titre de l\'article'],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => ['placeholder' => 'Rédigez le contenu de votre article...', 'rows' => 12],
            ])
            ->add('image', UrlType::class, [
                'label' => 'URL de l\'image',
                'attr' => ['placeholder' => 'https://exemple.com/image.jpg'],
            ])
            ->add('created_at', DateTimeType::class, [
                'label' => 'Date de publication',
                'widget' => 'single_text',
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
