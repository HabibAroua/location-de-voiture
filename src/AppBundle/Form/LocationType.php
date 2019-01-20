<?php

namespace AppBundle\Form;

use AppBundle\Entity\Location;
use AppBundle\Entity\User;
use AppBundle\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class LocationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder


            ->add('user', EntityType::class, array(
                'class'    => User::class,
                'choice_label' => 'username',
            ))

            ->add('voiture', EntityType::class, array(
                'class'    => Voiture::class,
                'choice_label' => 'matricule',
            ))

            ->add('date', DateType::class, array(
                'required' => true,
            ));





    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }



}
