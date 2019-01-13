<?php

namespace AppBundle\Form;

use AppBundle\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class VoitureType extends AbstractType
{   /**
 * {@inheritdoc}
 */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder


            ->add('matricule', TextType::class,[
                'attr' => [
                    'autofocus' => false,
                    'class' => 'col-md-6 col-sm-6 col-xs-12',
                    'required' => true
                ],
                'label' => 'Matricule :*'
            ])
            ->add('modele', TextType::class,[
                'attr' => [
                    'autofocus' => false,
                    'class' => 'col-md-6 col-sm-6 col-xs-12',
                    'required' => true
                ],
                'label' => 'Modele :*'
            ])

            ->add('moteur', TextType::class,[
            'attr' => [
                'autofocus' => false,
                'class' => 'col-md-6 col-sm-6 col-xs-12',
                'required' => true
            ],
            'label' => 'Moteur :*'
             ])

            ->add('constructeur', TextType::class,[
            'attr' => [
                'autofocus' => false,
                'class' => 'col-md-6 col-sm-6 col-xs-12',
                'required' => true
            ],
            'label' => 'Constructeur :*'
            ]);


    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }



}
