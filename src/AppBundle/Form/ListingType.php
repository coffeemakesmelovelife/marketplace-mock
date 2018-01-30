<?php

namespace AppBundle\Form;

use AppBundle\Entity\Listing;
use AppBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('category', EntityType::class, ['attr' => ['class' => 'form-control'],
            'class' => Category::class,
            'choice_label' => 'name'])
            ->add('price', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('size', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('image', FileType::class, ['attr' => ['class' => 'form-control']]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Listing::class,
        ));
    }

}