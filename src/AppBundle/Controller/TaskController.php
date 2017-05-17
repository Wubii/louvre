<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\MbTask;
use AppBundle\Entity\MbTag;
use AppBundle\Entity\MbPayment;

use AppBundle\Form\MbTaskType;
use AppBundle\Form\MbTagType;
use AppBundle\Form\MbPaymentType;


class TaskController extends Controller
{
    /**
     * @Route("/task", name="task")
     */
    public function formAction(Request $request)
    {
        $payment = new MbPayment();

        $form = $this->get('form.factory')->create(MbPaymentType::class, $payment);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            //return new Response('tartampion');
            
            if($form->isValid())
            {
                \Stripe\Stripe::setApiKey('sk_test_47A0sTmJ2aCxtYqAq6ye9DrK');

                $tokenJson = \Stripe\Token::create(array(
                    "card" => array(
                        "number" => $payment->getCardNumber(),
                        "exp_month" => $payment->getCardExpiryMonth(),
                        "exp_year" => $payment->getCardExpiryYear(),
                        "cvc" => $payment->getCardCVC()
                    )));

                $token = json_decode($tokenJson);

//                $charge = \Stripe\Charge::create(array('amount' => 2000, 'currency' => 'usd', 'source' => $token['id'] ));

                return new Response($tokenJson);
            }
        }

        // replace this example code with whatever you need
        return $this->render('default/task.html.twig', [
            'form' => $form->createView(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
