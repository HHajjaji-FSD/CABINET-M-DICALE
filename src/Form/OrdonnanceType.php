<?php

namespace App\Form;

use App\Entity\Medecament;
use App\Entity\Ordonnance;
use App\Entity\Radio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdonnanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prixFinal')
            ->add('radio', EntityType::class, [
                "label"=> "Radios",
                'required'=>false,
                "multiple" => true,
                "class" => Radio::class,
                'attr'=>[
                    'class'=>'select2'
                ],
                //"expanded" => true
            ])
            ->add('medicaments', EntityType::class, [
                "label"=> "Medicaments",
                'required'=>false,
                "multiple" => true,
                "class" => Medecament::class,
                'attr'=>[
                    'class'=>'select2'
                ],
                //"expanded" => true
            ])
            ->add('Save',SubmitType::class,[
                'label'=>'Engesf',
                'attr'=>['class' =>'btn btn-primary ml-4']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ordonnance::class,
        ]);
    }
}
