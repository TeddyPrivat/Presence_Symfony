<?php

namespace App\Form;

use App\Entity\Adherent;
use App\Entity\Seance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'id' => 'datetimepicker1'
                ],
                'label' => 'Date et heure de la séance'
            ])
            ->add('adherents', EntityType::class, [
                'class' => Adherent::class,
                'choice_label' => function (Adherent $adherent) {   // fonction callback qui permet d'afficher le prénom ainsi que le nom pour le label
                    return $adherent->getPrenom() . ' ' . $adherent->getNom();
                },
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
