<?php

namespace App\Form;

use App\Entity\fabriquant;
use App\Entity\Manekineko;
use App\Entity\user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManekinekoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteur')
            ->add('dateFabrication')
            ->add('nomFabriquant')
            ->add('estimation')
            ->add('description')
            ->add('user', EntityType::class, [
                'class' => user::class,
                'choice_label' => 'id',
            ])
            ->add('fabriquant', EntityType::class, [
                'class' => fabriquant::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manekineko::class,
        ]);
    }
}
