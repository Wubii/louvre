<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class MbOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visiteDate', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label'  => false
            ))

            ->add('duration', EntityType::class, array(
                'class' => 'AppBundle:MbDuration',
                'choice_label' => 'name',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ))

            ->add('email', EmailType::class, array(
                'label'  => false
            ))
            
            ->add('users', CollectionType::class, array(
                'entry_type'   => MbUserType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'        => false
            ))
            ->add('cardNumber', TextType::class, array(
                'label'        => false
            ))
            ->add('cardMonth', TextType::class, array(
                'label'        => false,
            ))
            ->add('cardYear', TextType::class, array(
                'label'        => false
            ))
            ->add('cardCVC', TextType::class, array(
                'label'        => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Réserver'
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MbOrder'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mborder';
    }


}
