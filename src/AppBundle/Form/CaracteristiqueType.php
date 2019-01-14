<?php

namespace AppBundle\Form;

use AppBundle\Entity\Caracteristique;
use AppBundle\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CaracteristiqueType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder


            ->add('voiture', EntityType::class, array(
                'class'    => Voiture::class,
                'choice_label' => 'modele',
            ))

            ->add('couleur', TextType::class,[
                'attr' => [
                    'autofocus' => false,
                    'class' => 'col-md-6 col-sm-6 col-xs-12',
                    'required' => true
                ],
                'label' => 'Couleur :*'
            ])

            ->add('nbrChevaux', TextType::class,[
                'attr' => [
                    'autofocus' => false,
                    'class' => 'col-md-6 col-sm-6 col-xs-12',
                    'required' => true
                ],
                'label' => 'Nombre de chevaux :*'
            ])
            ->add('prix', TextType::class,[
                'attr' => [
                    'autofocus' => false,
                    'class' => 'col-md-6 col-sm-6 col-xs-12',
                    'required' => true
                ],
                'label' => 'Prix :*'
            ]);





    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Caracteristique::class,
        ]);
    }



}
