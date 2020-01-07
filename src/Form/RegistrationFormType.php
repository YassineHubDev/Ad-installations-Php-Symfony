<?php
// src/App/Form/RegistrationFormType.php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('email', null, array ('label' => false))
            ->add('username', null, array ('attr' => array('placeholder' => 'Nom')))
            ->add('ville', null, array ('attr' => array('placeholder' => 'Ville')))
            ->add('raisonSociale', TextType::class, array ('attr' => array('placeholder' => 'Magasin'), 'required' => true))
            
    
             ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options'  => array('attr' => array('placeholder' => 'Mot de passe')),
                'second_options' => array('attr' => array('placeholder' => 'Répétez le mot de passe',)),
                'invalid_message' => 'Les mots de passe sont différents !',
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
            ])      

             ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Magasin' => 'ROLE_MAGASIN',
                    'Client' => 'ROLE_CLIENT',
                ],
                'multiple' => false,
                'expanded' => true,
                'mapped' => false
            ])
  
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
