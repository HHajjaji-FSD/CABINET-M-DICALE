<?php

namespace App\Form;

use App\Entity\RendezVous;
use App\Entity\Setting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeRdv', ChoiceType::class, [
                "choices" => array_flip(RendezVous::TYPES_RENDUVOUS),
                "label" => "Type"
            ])
            ->add('prixConsultation')
            ->add('numMatin')
            ->add('numMedi')
            ->add('nomCabinet')
            ->add('adresse')
            ->add('telephone')
            ->add('specialite')
            ->add('logo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Setting::class,
        ]);
    }
}
