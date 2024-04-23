<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Questions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isCorrect', ChoiceType::class, [
                'placeholder' => 'Choisir le vrai reponse...',
                'choices' => [
                    'vrai' => true,
                    'Faux' => false,
                ],
            ])
            ->add('text')
            ->add('question', EntityType::class, [
                'class' => Questions::class,
                'label' => 'Question',
                'placeholder' => 'Choisissez la question...',
                'choice_label' => function (Questions $questions) {
                    return $questions->getText();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
