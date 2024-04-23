<?php

namespace App\Form;

use App\Entity\QuestionGroupLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionGroupLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('level', ChoiceType::class, [
                'placeholder' => 'Choisir le niveau...',
                'choices' => [
                    'Facile' => 'facile',
                    'Difficile' => 'difficile',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuestionGroupLevel::class,
        ]);
    }
}
