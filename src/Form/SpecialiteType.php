<?php

namespace App\Form;

use App\Entity\Gouvernorat;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class SpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>"Libellé specialité",
                ],
                'label' => 'Libellé specialité',
                'label_attr' => ['class' => 'mt-3'],
            ])
            ->add('gouvernorats', EntityType::class, [
                'class' => Gouvernorat::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.id', 'ASC');
                    },
                    'attr' => [
                        'class' => 'select2 form-select shadow-none mt-3',
                    ],
                'label' => 'Gouvernorat',
                'label_attr' => ['class' => 'mt-3'],
                'choice_label' => 'libelle_gouv',
                'required'   => true,
                'multiple' => true,
                'expanded' => false,
            ]);
        
               
           
          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Specialite::class,
        ]);
    }
}
