<?php

namespace App\Form;

use App\Entity\Arrazoia;
use App\Entity\Hizkuntza;
use App\Entity\Job;
use App\Entity\Saila;
use App\Entity\SailkapenTaldea;
use App\Entity\Titulazioa;
use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jobType', EntityType::class,[
                'class' => \App\Entity\JobType::class,
                'label' => 'Eskaera mota',
                'placeholder' =>'Aukeratu bat',
                'required' => true,
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('saila', EntityType::class, [
                'class' => Saila::class,
                'placeholder' => 'Aukeratu bat',
                'required' => true,
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'Tramitatzailea',
                'placeholder' => 'Tramitatzailea',
                'required' => true,
                'disabled' => true
            ])
            ->add('arrazoia', EntityType::class, [
                'class' => Arrazoia::class,
                'label' => 'Arrazoia / Motivo',
                'placeholder' => 'Aukeratu bat',
                'required' => true,
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Lanpostua / Puesto de trabajo',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Hasiera / Comienzo',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker col-md-2',
                ]
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'Bukaera / Fin',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker col-md-2'
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Azalpenak / Petici??n detallada',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('created', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'label' => 'Eskaera data / Fecha de solicitud',
                'disabled' => false,
                'attr' => [
                    'class' => 'datepicker col-md-2'
                ]
            ])
            ->add('eginkizunak', CKEditorType::class, [
                'label' => 'Eginkizunak / Tareas',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('sailkapenTalea', EntityType::class, [
                'class' => SailkapenTaldea::class,
                'required' => false,
                'label' => 'Sailkapen taldea',
                'placeholder' => 'Aukeratu bat',
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('hizkuntza', EntityType::class, [
                'class' => Hizkuntza::class,
                'required' => false,
                'label' => 'Hizkuntz eskakizuna',
                'placeholder' => 'Aukeratu bat',
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('eskatutakoTitulazioa', null, [
                'label' => 'Eskatutako titulazioa',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
//            ->add('titulazioa',EntityType::class, [
//                'class' => Titulazioa::class,
//                'required' => false,
//                'label' => 'Eskatutako titulazioa',
//                'placeholder' => 'Aukeratu bat',
//                'attr' => [
//                    'class' => 'myselect2'
//                ]
//            ])
            ->add('bestebatzuk', CKEditorType::class, [
                'label' => 'Beste batzuk / Otros',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
