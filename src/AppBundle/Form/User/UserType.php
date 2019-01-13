<?php

namespace AppBundle\Form\User;

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

class UserType extends AbstractType
{   /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options["data"];
        $roles = $user->getRoles();
        $array_roles = [];
            $array_roles = ["MANAGER"=>"ROLE_MANAGER","CLIENT" => "ROLE_CLIENT"];

        $builder


            ->add('username', TextType::class,[
                'attr' => [
                    'autofocus' => false,
                    'class' => 'col-md-6 col-sm-6 col-xs-12',
                    'required' => true
                ],
                'label' => 'UserName :*'  ,

            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'col-md-6 col-sm-6 col-xs-12'
                ],
                'label' => 'Email :* ',

            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                        'required' =>false
                    ),
                ),

                'first_options' => array('label' => 'form.password'),
                'second_options' => array(
                    'label' => 'form.password_confirmation'),
                'required' => false,
                'invalid_message' => 'fos_user.password.mismatch',
            ))

            ->add('roles', ChoiceType::class, array(

                'choices' =>$array_roles,
                'multiple' => true,
                'required' => true,
            ))

            ->add('phoneNumber', TextType::class, [
                'label' => 'Phone Number : ',
                'required' => false,
            ])


            ->add('enabled', CheckboxType::class, array(
                'required' => true,
            ))

            ->add('file');
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
