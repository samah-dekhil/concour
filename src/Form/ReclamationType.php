<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Grade;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom',TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',
                    
                ],
                'label' => 'الإسـم<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required'   => true,
            ])
            ->add('nom',TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',
                   
                ],
                 'label' => 'اللقـب<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3 '],
                'label_html' => true, 'required'   => true,

            ])
         
            ->add('cin',TextType::class, [
                'attr' => [
                    'class' => 'form-control required',
                ],
             
                'label' => 'رقم بطاقة التعريف الوطنية <font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'], 
                'label_html' => true, 'required'   => true
            ])
            ->add('dateCin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy/M/d',
               'label' => '    تاريـخ   الإصـدار <font style="color:red">*</font>:',
               'label_attr' => ['class' => 'mt-3'],
               'attr' => [
                   'class' => 'form-control   required datepicker-auto dte',
                    'placeholder'=>"",
               ],
               'label_html' => true,
                'required'   => true,
               'html5' => false,
           ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd',
                'label' => ' تاريخ الولادة<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'attr' => [
                   'class' => 'form-control   required datepicker-auto dte',
                    'placeholder'=>"",
                ],
               'label_html' => true,
                'required'   => true,
               'html5' => false,
           ])
            ->add('mail',EmailType::class, [
                'attr' => [
                    'class' => 'form-control required',
                ],
                'label' => '  العنوان الإلكتروني<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required'   => true,
            ])
          
            ->add('objet', ChoiceType::class, [
                'label' => '  السؤال  <font style="color:red">*</font>:',
                'label_html' => true,
                'label_attr' => ['class' => 'mt-3'],
                 'required'   => true,
                'multiple' => false,
                'expanded' => true,
                'choices'  =>  array('هل تواجه مشكل في تسجيل مطلب الترشح؟'=>'هل تواجه مشكل في تسجيل مطلب الترشح؟',
                                    'هل تواجه مشكل في  طباعة مطلب الترشح؟'=>'هل تواجه مشكل في  طباعة مطلب الترشح؟',
                                    
                                ),
            ])
            ->add('grade', EntityType::class, [
                'class' => Grade::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                    },
                    'attr' => [
                        'class' => 'select222 form-select shadow-none required',
                    ],        
                'label' => ' رتبة الإنتداب<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3 '],
                'choice_label' => 'libelle',
                'placeholder' => '  ',
                'label_html' => true,
                'required'   => true,
                'multiple' => false,
                'expanded' => false
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
