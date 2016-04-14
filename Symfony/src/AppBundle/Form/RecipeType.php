<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\StepType;

class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('ingredients', CollectionType::class, array(
              'entry_type' => IngredientType::class,
              'allow_add' => true,
              'by_reference' => false,))
            ->add('category')
            ->add('duration', TimeType::class)
            ->add('steps', CollectionType::class, array(
              'entry_type' => StepType::class,
              'allow_add' => true,
              'by_reference' => false,
            ))
            ->add('isPublished')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recipe'
        ));
    }
}
