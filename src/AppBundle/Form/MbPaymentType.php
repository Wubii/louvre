<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MbPaymentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardNumber', IntegerType::class, array(
                'label'  => 'Numéro de carte bleue',
                'attr'=> array('class'=>'card-number')
            ))

            ->add('cardExpiryMonth', IntegerType::class, array(
                'label'  => 'Date d\'expiration',
                'attr'=> array('class'=>'card-expiry-month')
            ))

            ->add('cardExpiryYear', IntegerType::class, array(
                'label'  => '',
                'attr'=> array('class'=>'card-expiry-year')
            ))

            ->add('cardCVC', IntegerType::class, array(
                'label'  => 'CVC',
                'attr'=> array('class'=>'card-cvc')
            ))

            ->add('stripeToken', HiddenType::class, array(
                'attr'=> array('name'=>'stripeToken')
            ))

            ->add('save', SubmitType::class, array(
                'label' => 'Paiement'
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MbPayment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mbpayment';
    }


}
