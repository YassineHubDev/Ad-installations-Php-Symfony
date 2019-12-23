<?php
// src/App/Form/RegistrationFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('email', null, array ('label' => false))
            ->add('username', null, array ('attr' => array('placeholder' => 'Nom')))
            ->add('ville', null, array ('attr' => array('placeholder' => 'Ville')))
            ->add('raisonSociale', TextType::class, array ('attr' => array('placeholder' => 'Magasin'), 'required' => true))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options'   => array('attr' => array('placeholder' => 'Mot de passe')),
                'second_options'  => array('attr' => array('placeholder' => 'Répétez le mot de passe',)),
                'invalid_message' => 'fos_user.password.mismatch',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ))
            
            ->add('roles', CollectionType::class, [
            'entry_type'   => ChoiceType::class,
            'entry_options'  => [
                'label' => false,
                'choices' => [
                    'Magasin' => 'ROLE_MAGASIN',
                    'Client'  => 'ROLE_CLIENT',
                ],
            ],
            ])
  
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }
    
    

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
