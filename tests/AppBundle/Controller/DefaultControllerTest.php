<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\Controller;

class DefaultControllerTest extends Controller
{
    public function stripeOrderTest()
    {
       \Stripe\Stripe::setApiKey('sk_test_47A0sTmJ2aCxtYqAq6ye9DrK');

        $token = \Stripe\Token::create(array(
            "card" => array(
                "number" => $order->setCardNumber('4242424242424242'),
                "exp_month" => $order->setCardMonth('12'),
                "exp_year" => $order->setCardYear('18'),
                "cvc" => $order->setCardCVC('123')
            )));

        $charge = \Stripe\Charge::create(array(
            'amount' => '16',
            'currency' => 'eur',
            'source' => $token->id 
        ));

        //return new Response($charge);
    }
}
