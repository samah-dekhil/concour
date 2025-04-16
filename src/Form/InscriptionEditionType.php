<?php

namespace App\Form;
use App\Entity\Specialite;
use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
class InscriptionEditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       
        ->add('cin_search',TextType::class, [
            'attr' => [
                'class' => 'form-control required',
            ],
            'mapped'=>false,
            'label' => 'أدخل رقم بطاقة التعريف الوطنيّة:',
            'label_attr' => ['class' => 'mt-3'], 
            'required'   => true
        ])
         ->add('dateCin', DateType::class, [
                'widget' => 'single_text',
                // 'format' => 'yyyy-MM-dd',
                'label' => 'أدخل تاريـخ الإصـدار : ',
                'label_attr' => ['class' => 'mt-3'],
                'attr' => [
                    'class' => 'form-control datepicker-autoclose required',
                     'placeholder'=>"",
                ],
                'required'   => true,
                'empty_data' => '',
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                // 'format' => 'yyyy-MM-dd',
                'label' => 'أدخل تاريـخ الولادة  : ',
                'label_attr' => ['class' => 'mt-3'],
                'attr' => [
                    'class' => 'form-control datepicker-autoclose required',
                     'placeholder'=>"",
                ],
                'required'   => true,
                'empty_data' => '',
            ])
   
             ;
    
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}