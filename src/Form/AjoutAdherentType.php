<?php

namespace App\Form;

use App\Entity\Adherent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutAdherentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'label'=> 'Nom',
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prénom'
            ] )
            ->add('age', IntegerType::class, [
                'label' => 'Âge'
            ])
            ->add('ceinture', ChoiceType::class, [
                'choices' => [
                    'Blanche' => 'Blanche',
                    'Bleue' => 'Bleue',
                    'Violette' => 'Violette',
                    'Marron' => 'Marron',
                    'Noire' => 'Noire',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}
