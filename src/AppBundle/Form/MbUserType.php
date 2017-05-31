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
                    'class' => 'focus blur index')
            ))
            ->add('lastname', TextType::class, array(
                'label'  => 'Nom',
                'attr' => array(
                    'class' => 'focus blur')
            ))
            ->add('birthday', BirthdayType::class, array(
                'label'  => 'Date de naissance',
                'attr' => array(
                    'class' => 'focus blur')
            ))
            ->add('country', CountryType::class, array(
                'label'  => 'Pays'
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
