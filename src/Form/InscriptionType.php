<?php

namespace App\Form;

use App\Entity\Gouvernorat;
use App\Entity\Inscription;
use App\Entity\Specialite;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {// $entityManager = $options['entityManager'];
        $current = $options['data'];

        $builder
            ->add('grade', HiddenType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
            ->add('cin', TextType::class, [
                'attr' => [
                    'class' => 'form-control required',
                ],

                'label' => 'رقم بطاقة التعريف الوطنية <font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])

            ->add('dateCin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd',
                'label' => '    تاريـخ   الإصـدار <font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'attr' => [
                    'class' => 'form-control   required datepicker-auto dte',
                    'placeholder' => "",
                ],
                'label_html' => true,
                'required' => true,
                //    'empty_data' => '',
                'html5' => false,
            ])

            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',

                ],
                'label' => 'الإسـم<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',

                ],
                'label' => 'اللقـب<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3 '],
                'label_html' => true, 'required' => true,

            ])
            ->add('prenomPere', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',
                ],
                'label' => 'إسم الأب<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            ->add('prenomMere', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',
                ],
                'label' => 'إسم الأم<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
          /*  ->add('nomJeunefille', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',
                    //
                ],
                'label' => 'اللقب قبل الزواج ( للمترشحة المتزوجة أو الأرملة) <font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])*/

            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd',
                'label' => ' تاريخ الولادة<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'attr' => [
                    'class' => 'form-control   required datepicker-auto dte',
                    'placeholder' => "",
                ],
                'label_html' => true,
                'required' => true,
                //    'empty_data' => '',
                'html5' => false,
            ])

            ->add('villeNaissance', EntityType::class, [
                'class' => Gouvernorat::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'attr' => [
                    'class' => 'select222 form-select shadow-none required',
                ],

                'label' => 'مكان الولادة<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3 '],
                'choice_label' => 'libelleGouv',
                'placeholder' => '  ',
                'label_html' => true, 'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])

            ->add('sexe', ChoiceType::class, [
                'label' => 'الجنــس<font style="color:red">*</font>:',
                // 'attr' => [
                //     'class' => 'form-check-input required',
                // ],
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true,
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => array('ذكر' => 'ذكر',
                    'أنثى' => 'أنثى'),
            ])

            ->add('etatCivil', ChoiceType::class, [
                'label' => 'الحالة العائلية<font style="color:red">*</font> :',
                'attr' => [
                    'class' => 'select222 form-select shadow-none required',
                ],
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
                'multiple' => false,
                'expanded' => false,
                'placeholder' => '  ',
                'choices' => array('أعزب' => 'أعزب',
                    'متزوج' => 'متزوج',
                    'مطلق' => 'مطلق',
                    'أرمل' => 'أرمل'),
            ])
            ->add('nomPrenomConjoint', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract4',
                ],
                'label_html' => true, 'required' => false,
                'label' => ' إسم ولقب القرين:',
                'label_attr' => ['class' => 'mt-3'],
            ])
            ->add('emploiConjoint', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract',
                    'maxlength' => 30,
                ],
                'label' => 'المهنـــة :',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => false,
            ])
            ->add('nbEnfants', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'عـدد الأبنـاء:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => false,
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control required special_caract',
                ],
                'label' => 'مكان الإقامـة<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            // ->add('num_adresse',TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control required',
            //     ],
            //     'mapped'=>false,
            //     'label' => ' العدد<font style="color:red">*</font>:',
            //     'label_attr' => ['class' => 'mt-3'],
            //     'label_html' => true, 'required'   => true,
            // ])

            ->add('regionAdresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control required special_caract',
                ],

                'label' => '  البلديّة أوالمعتمدية<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])

            ->add('codeGouvAdresse', EntityType::class, [
                'class' => Gouvernorat::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'attr' => [
                    'class' => 'select222 form-select shadow-none required',
                ],

                'label' => ' الولاية<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3 '],
                'choice_label' => 'libelleGouv',
                'placeholder' => '  ',
                'label_html' => true, 'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('codePostal', TextType::class, [
                'attr' => [
                    'class' => 'form-control required',

                ],
                'label' => ' الترقيم البريدي<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            //->add('telephoneFixe', TextType::class, [
              //  'attr' => [
                //    'class' => 'form-control',

              //  ],
               // 'label' => 'رقم الهاتـف القـارّ<font style="color:red">*</font>:',
               // 'label_attr' => ['class' => 'mt-3'],
               // 'label_html' => true, 'required' => true,
           // ])
            ->add('telephonePortable', NumberType::class, [
                'attr' => [
                    'class' => 'form-control required',
                ],
                'label' => '  الجـوّال<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            ->add('mail', EmailType::class, [
                'attr' => [
                    'class' => 'form-control required',
                ],
                'label' => '  العنوان الإلكتروني<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            ->add('niveau', ChoiceType::class, [
                'label' => 'المستـوى التعليمـي<font style="color:red">*</font>:',
                'label_html' => true, 'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => array(' شهادة مهندس ' => 'ing'
                   /* ' الشهادة الجامعية للمرحلة الأولى من التعليم العالي على الأقل أو شهادة معادلة لها في إختصاص : (الحقوق أو العلوم الاقتصادية )' => '1er cycle',*/
                    /*'شهادة تكوينية منظرة بالمستوى الرابع من سلم الوظائف  في إختصاص : (الحقوق أو العلوم الاقتصادية )' => 'formation',*/
                ),
            ])
            // ->add('niveauAffiche')

            ->add('nomDiplome', TextType::class, [
                'attr' => [
                    'class' => 'form-control required special_caract',
                ],
                'label' => '   إسم الشهادة المتحصّل عليها<font style="color:red">*</font>:',
                'label_html' => true,
                'required' => true, 'label_attr' => ['class' => 'mt-3'],
            ])
            ->add('specialiteDiplome', TextType::class, [
                'attr' => [
                    'class' => 'form-control special_caract',
                ],
                'label' => '      الإختصاص في الشهادة<font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])

            ->add('typeEtablissement', ChoiceType::class, [
                'label' => 'صـادرة عـن<font style="color:red">*</font>: ',
                // 'attr' => [
                //     'class' => 'form-check-input ',
                // ],
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => array('مؤسّسة وطنية' => 'وطنية',
                    'مؤسّسة خاصّة' => 'خاصّة',
                    'مؤسّسة أجنبيّة' => 'أجنبيّة'),
            ])
            ->add('anneeDiplome', TextType::class, [
                'attr' => [
                    'class' => 'form-control required',
                ],
                'label' => '  سنة الحصول على الشهادة (سنة التخرّج) <font style="color:red">*</font>:',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            ->add('anneeEquivalence', TextType::class, [
                'attr' => [
                    'class' => 'form-control ',
                ],
                'label' => '  سنة الحصول على مقرر المعادلة <font style="color:red">*</font>:',
                'label_html' => true,
                'label_attr' => ['class' => 'mt-3'],
                'required' => false,
            ])
            ->add('nomEtablissement', TextType::class, [
                'attr' => [
                    'class' => 'form-control required special_caract',
                ],
                'label' => '   إسم مؤسّسة التعليم العالي <font style="color:red">*</font>: ',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])

            ->add('scoreTanfil', TextType::class, [
                'attr' => [
                    'class' => 'form-control check-moy ', 'data-m' => '5',
                ],
                'label' => '     المعدل المتحصل عليه في الباكالوريا : ',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])

            ->add('moyenne1', TextType::class, [
                'attr' => [
                    'class' => 'form-control required check-moy', 'data-m' => '1',
                    // 'placeholder'=>"................/20",
                ],
                'label' => 'المعدل العام للسنة الأولى بنجاح : (1)',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            ->add('moyenne2', TextType::class, [
                'attr' => [
                    'class' => 'form-control required check-moy', 'data-m' => '2',
                ],
                'label' => 'المعدل العام للسنة الثانية بنجاح : (2)',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => true,
            ])
            ->add('moyenne3', TextType::class, [
                'attr' => [
                    'class' => 'form-control check-moy', 'data-m' => '3',
                ],

                'label' => 'المعدل العام للسنة الثالثة بنجاح : (3)',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => false,
            ])
            ->add('moyenne4', TextType::class, [
                'attr' => [
                    'class' => 'form-control check-moy',
                    'data-m' => '4',
                ],
                'label' => 'المعدل العام للسنة الرابعة  بنجاح : (4)',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => false,
            ])
         /*  ->add('moyenne5', TextType::class, [
                'attr' => [
                    'class' => 'form-control check-moy', 'data-m' => '5',
                ],
                'label' => 'المعدل العام للسداسي الخامس بنجاح : (5)',
                'label_attr' => ['class' => 'mt-3'],
                'label_html' => true, 'required' => false, 
            ])  */

            // ->add('moyenneGenerale')
            /*->add('scoreTanfil', ChoiceType::class, [
                'label' => ' متحصل على شهادة البكالوريا بملاحظة <font style="color:red">*</font>:',
                'attr' => [
                    'class' => 'select222 form-select shadow-none ',
                ],
                'label_attr' => ['class' => 'mt-3'],
                'placeholder' => '  ',
                'label_html' => true,
               
                'multiple' => false,
                'expanded' => false,
                'choices' => array('متوسط' => 'متوسط',
                    'قريب من الحسن أو فوق المتوسّط' => 'قريب من الحسن أو فوق المتوسّط',
                    'حسن' => 'حسن',
                    'حسن جدا' => 'حسن جدا'),
            ])*/

        

       

           ->add('diplomeTanfil', ChoiceType::class, [
                'label' => '      ',
                // 'attr' => [
                //     'class' => 'form-check-input required',
                // ],
                'label_attr' => ['class' => 'hidelabel'],
                'label_html' => true,
                'required' => true,
                'multiple' => false,
                'expanded' => true,
           //  'choices' => array('متحصل على شهادة البكالوريا ' => 'bac')
                    // ' متحصل على شهادة تكوين منظرة بالمستوى الثالث من سلم الوظائف الوطني ' => 'formation'),
            ])

            //->add('totalScore')
                ->add('confirmDecision', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input required ',

                ],
                'label' => 'نعم إطّلعت على قرار ضبط  كيفيّة تنظيم المناظرة<font style="color:red">*</font>',
                'label_attr' => ['class' => 'form-check-label mb-0'],
                'label_html' => true, 'required' => true,
            ])
            ->add('confirmProgramme', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input required ',

                ],
                'label' => '   نعم إطّلعت على برنامج المناظرة <font style="color:red">*</font>',
                'label_attr' => ['class' => 'form-check-label mb-0'],
                'label_html' => true, 'required' => true,
            ])
            ->add('confirmFiche', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input required ',

                ],
                'label' => ' نعم إطّلعت على بطاقة عناصر التقييم   <font style="color:red">*</font>',
                'label_attr' => ['class' => 'form-check-label mb-0'],
                'empty_data' => true, 'label_html' => true,
            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'attr' => [
                    'class' => 'select222 form-select shadow-none required',
                ],

                'label' => 'اختصاص الترشح  <font style="color:red">*</font> :',
                'label_attr' => ['class' => 'mt-3 '],
                'choice_label' => 'libelle',
                'placeholder' => '  ',
                'label_html' => true, 'required' => true,
                'multiple' => false,
                'expanded' => false,
            ]);

        $formModifier = function (FormInterface $form, Specialite $specialite = null): void {
        $positions = null === $specialite ? [] : $specialite->getGouvernorats();

        };
         /*  $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier): void {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getSpecialite());
            }
        ); */

    /*    $builder->get('specialite')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier): void {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $specialite = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback function!
                $formModifier($event->getForm()->getParent(), $specialite);
            }
        );  */

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        //$resolver->setRequired(array('entityManager'));
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
