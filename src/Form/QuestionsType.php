<?php

namespace App\Form;

use App\Entity\QuestionGroupLevel;
use App\Entity\Questions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text')
            ->add('questionGroupLevel', EntityType::class, [
                'class' => QuestionGroupLevel::class,
                'label' => 'Groupe de question',
                'placeholder' => 'Choisissez le groupe de question',
                'choice_label' => function (QuestionGroupLevel $questionGroupLevel) {
                    return $questionGroupLevel->getName();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}
