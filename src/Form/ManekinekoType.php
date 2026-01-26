<?php

namespace App\Form;

use App\Entity\Fabriquant;
use App\Entity\Manekineko;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;
use App\Repository\FabriquantRepository;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ManekinekoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du Manekineko',
            ])

            ->add('dateFabrication', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])

            ->add('estimation', IntegerType::class, [
                'required' => false,
            ])

            ->add('fabriquant', EntityType::class, [
                'class' => Fabriquant::class,
                'choice_label' => 'nom',
                'required' => true,
                'placeholder' => false,
                'query_builder' => function (FabriquantRepository $repo) {
                    return $repo->createQueryBuilder('f')
                        ->addOrderBy("CASE WHEN f.nom = 'inconnu' THEN 0 ELSE 1 END", 'ASC')
                        ->addOrderBy('f.nom', 'ASC');
                },
            ])


            ->add('nouveauFabriquant', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Nouveau fabriquant (si absent)',
                'attr' => ['placeholder' => 'Hiroima'],
            ])

            ->add('description', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajoutez une description...',
                ],
            ])

            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Changer l’image (optionnel)',
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
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
