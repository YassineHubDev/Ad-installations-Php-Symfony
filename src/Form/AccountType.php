<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array ('label' => "Nom"))
            ->add('raisonSociale', null, array ('label' => "Magasin", 'required' => true))
            ->add('ville')
            ->add('email', null, array ('label' => "Email"))
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Magasin' => 'ROLE_MAGASIN',
                    'Client' => 'ROLE_CLIENT',
                ],
                'multiple' => false,
                'expanded' => true,
                'mapped' => false
            ])
            
//            ->add('submit', SubmitType::class, array(
//                'attr' => array(
//                    'class' => 'btn btn-primary btn-block',
//                    'required' => true,
//                )
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
