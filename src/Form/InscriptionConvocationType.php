<?php

namespace App\Form;
use App\Entity\Specialite;
use App\Entity\InscriptionConvocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
class InscriptionConvocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('idDossier',TextType::class, [
            'attr' => [
                'class' => 'form-control required',
            ],
            'mapped'=>false,
            'label' => 'رقم التسجيل:',
            'label_attr' => ['class' => 'mt-3'], 
            'required'   => true
        ])


        /*  ->add('cin', TextType::class, [
                'attr' => [
                    'class' => 'form-control required',
                ],

                'label' => 'رقم بطاقة التعريف الوطنية <font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])  */
       
        ->add('cin',TextType::class, [
            'attr' => [
                'class' => 'form-control required',
            ],
            'mapped'=>false,
           'label' => 'رقم بطاقة التعريف الوطنية : ',
            'label_attr' => ['class' => 'mt-3'], 
            'required'   => true
        ])
    
            
             ;
    
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InscriptionConvocation::class,
        ]);
    }
}