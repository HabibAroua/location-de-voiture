<?php

namespace AppBundle\Form;

use AppBundle\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VoitureType extends AbstractType
{

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
            ])
            ->add('file');



    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }



}
