<?php

namespace App\Form;

use App\Entity\Phase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;




class PhaseType extends AbstractType
{  
  
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $current = $options['data'];
        
            $builder
            ->add('libelle',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>"Libellé phase",
                ],
                'label' => 'Libellé phase',
                'label_attr' => ['class' => 'mt-3'],
            ])
         
            ->add('dateDebut', DateType::class, [
                    'widget' => 'single_text',
                    // 'format' => 'yyyy-MM-dd',
                    'label' => 'Date  début ',
                    'label_attr' => ['class' => 'mt-3'],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder'=>"dd/mm/yyyy",
                    ],
                ])
                ->add('dateFin', DateType::class, [
                    'widget' => 'single_text',
                    'label' => 'Date  fin ',
                    'label_attr' => ['class' => 'mt-3'],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder'=>"dd/mm/yyyy",
                    ],
                ])
              
                   
                ->add('isEnabled',CheckboxType::class, [
                    'attr' => [
                        'class' => 'form-check-input ',
                        'style'=>'margin-top: 0px;margin-right:8px;'
                    ],    
                    'label' => 'Activée',
                    'label_attr' => ['class' => 'form-check-label mb-0'],
                    'required'=>false
                    
                    ]) ;
                $formModifier = function (FormInterface $form,$current): void {
                    $gradesConcours =[];
                    if($current->getConcours() != null){
        
                        foreach($current->getConcours()->getGrades() as $grade){
                            $gradesConcours[$grade->getLibelle()]=$grade->getId();
                        };
                    }
       
            
                    $form ->add('grades',ChoiceType::class, [
                        'label' => ' Grade:',
                        'attr' => [
                            'class' => 'select2 form-select shadow-none mt-3',
                        ],
                            'label_attr' => ['class' => 'mt-3'],
                        'placeholder' => '  ',
                            'label_html' => true,
                            /* 'required'   => true,*/
                        'multiple' => true,
                        'expanded' => false,
                        'choices'  => $gradesConcours,
                        
                    ]);
                };
                $builder
                    ->addEventListener(
                        FormEvents::PRE_SET_DATA, 
                        function (FormEvent $event) use ($formModifier, $current){
                            $data = $event->getData();
                            $formModifier($event->getForm(),  $current);
                        }
                    );
        
        
            

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Phase::class,
        ]);
    }
}