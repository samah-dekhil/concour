<?php

namespace App\Form;

use App\Entity\Grade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>"Libellé grade",
                ],
                'label' => 'Libellé grade',
                'label_attr' => ['class' => 'mt-3'],
            ])
           
            ->add('nbrePostes', TextType::class, [
                 
                    'label' => 'Nombre de postes',
                    'label_attr' => ['class' => 'mt-3'],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder'=>"nombre de postes",
                    ],
                ])
               
           
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
        ]);
    }
}
