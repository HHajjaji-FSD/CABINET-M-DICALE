<?php

namespace App\Form;

use App\Entity\Consultation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'premiere fois'=>'premiere fois',
                    'controle'=>'controle',
                    'suivi'=>'suivi',
                ],
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('observationRec',TextareaType::class,[
                'attr'=>[
                    'rows'=>'3'
                ],
                'required'=>false
            ])
            ->add('observationMedcine',TextareaType::class,[
                'attr'=>[
                    'rows'=>'3'
                ],
                'required'=>false
            ])
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
