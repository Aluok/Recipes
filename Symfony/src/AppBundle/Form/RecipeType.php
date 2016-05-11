<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use AppBundle\Form\StepType;
use AppBundle\Entity\Recipe;

class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'recipe.title.name',
                'translation_domain' => 'app',
            ))
            ->add('ingredients', CollectionType::class, array(
                'label' => 'recipe.title.ingredient',
                'translation_domain' => 'app',
                'entry_type' => IngredientType::class,
                'allow_add' => true,
                'by_reference' => false,
            ))
            ->add('category', ChoiceType::class, array(
                'label' => 'recipe.title.category',
                'translation_domain' => 'app',
                'choices' => Recipe::CATEGORIES,
            ))
            ->add('duration', TimeType::class, array(
                'label' => 'recipe.title.duration',
                'translation_domain' => 'app',
            ))
            ->add('steps', CollectionType::class, array(
                'label' => 'recipe.title.step',
                'translation_domain' => 'app',
                'entry_type' => StepType::class,
                'allow_add' => true,
                'by_reference' => false,
            ))
            ->add('isFinished', CheckboxType::class, array(
                'label' => 'recipe.title.isfinished',
                'translation_domain' => 'app',
            ))
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
