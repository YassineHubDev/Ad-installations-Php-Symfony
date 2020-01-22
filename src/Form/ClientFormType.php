<?php

namespace App\Form;

use App\Entity\Client;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('sujet', null, array ('attr' => array('placeholder' => 'Sujet')))            
            ->add('telephone', null, array ('attr' => array('placeholder' => 'Téléphone'), 'required' => false))
            ->add('projet', null, array ('attr' => array('placeholder' => 'Votre message...'), 'required' => true))
            ->add('imageFile', VichImageType::class, [
                'required' => false
            ])

            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
