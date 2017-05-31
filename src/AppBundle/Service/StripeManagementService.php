<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;


class StripeManagementService 
{
    public function getStripeService($order)
    {
        \Stripe\Stripe::setApiKey('sk_test_47A0sTmJ2aCxtYqAq6ye9DrK');

        $token = \Stripe\Token::create(array(
            "card" => array(
                "number" => $order->getCardNumber(),
                "exp_month" => $order->getCardMonth(),
                "exp_year" => $order->getCardYear(),
                "cvc" => $order->getCardCVC()
            )));

        $charge = \Stripe\Charge::create(array(
            'amount' => strval($order->getPrice()*100),
            'currency' => 'eur',
            'source' => $token->id 
        ));

        //return new Response($charge);
    }
}