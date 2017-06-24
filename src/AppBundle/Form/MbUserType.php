<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MbUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label'  => 'Prénom',
                'attr' => array(
                    'class' => 'focus blur index not-empty',
                    'style' => 'width:315px'
                )
            ))
            ->add('lastname', TextType::class, array(
                'label'  => 'Nom',
                'attr' => array(
                    'class' => 'focus blur not-empty',
                    'style' => 'width:315px'
                )
            ))
            ->add('birthday', BirthdayType::class, array(
                'label'  => 'Date de naissance',
                'placeholder' => '--',
                'attr' => array(
                    'class' => 'focus blur is-not-empty'
                )
            ))
            ->add('country', CountryType::class, array(
                'label'  => 'Pays',
                'attr' => array(
                    'style' => 'width:315px'
                ),
                'preferred_choices' => array('France', 'Royaume-uni')
            ))
            ->add('isReduced', CheckboxType::class, array(
                'label' => 'Tarif réduit (sur présentation d\'un justificatif*)',
                'attr' => array('style' => 'margin-top:0'),
                'required' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MbUser'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mbuser';
    }


}
