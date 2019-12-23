<?php

namespace App\Form;

use App\Entity\Magasin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class MagFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('sujet', null, array ('attr' => array('placeholder' => 'Sujet')))
            ->add('telephone', null, array ('attr' => array('placeholder' => 'Téléphone')))
            ->add('projet', null, array ('attr' => array('placeholder' => 'Votre message')))
            ->add('imageFile', VichImageType::class)
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Magasin::class,
        ]);
    }
}

