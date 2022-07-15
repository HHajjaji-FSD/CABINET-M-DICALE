<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('sexe',ChoiceType::class, [
                'choices'  => [
                    'femme' => 'Femme',
                    'homme' => 'Homme'
                ],
                'attr'=>['class' =>'form-control']
            ])
            ->add('dateNaiss', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('numMetuale')
            ->add('typeMetuale',ChoiceType::class, [
                'choices'  => [
                    "Aucun" => null,
                    'CNSS' => 'cnss',
                    'CNOPS' => 'cnops'
                ],
                'attr'=>['class' =>'form-control']
            ])
            ->add('cin')
            ->add('responsable')
            ->add('Enregistrer',SubmitType::class,[
                'attr'=>['class' =>'btn btn-primary']
            ])
            ->add('maladieCroniques', TextareaType::class, [
                "label" => "Maladies Cronique",
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
