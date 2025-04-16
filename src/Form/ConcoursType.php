<?php

namespace App\Form;

use App\Entity\Concours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class ConcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>"Libellé Concours",
                ],
                'label' => 'Libellé Concours',
                'label_attr' => ['class' => 'mt-3'],
            ])
           
            ->add('dateDebutInscription', DateType::class, [
                    'widget' => 'single_text',
                    // 'format' => 'yyyy-MM-dd',
                    'label' => 'Date  début inscription',
                    'label_attr' => ['class' => 'mt-3'],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder'=>"dd/mm/yyyy",
                    ],
                ])
                ->add('dateFinInscription', DateType::class, [
                    'widget' => 'single_text',
                    'label' => 'Date  fin inscription',
                    'label_attr' => ['class' => 'mt-3'],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder'=>"dd/mm/yyyy",
                    ],
                ])
           
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concours::class,
        ]);
    }
}
