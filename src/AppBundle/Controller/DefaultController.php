<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\Entity\MbOrder;
use AppBundle\Entity\MbTicket;
use AppBundle\Entity\MbUser;

use AppBundle\Form\MbOrderType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $order = new MbOrder();
        //$user = new MbUser();

        //$order->getUsers()->add($user);

        $form = $this->get('form.factory')->create(MbOrderType::class, $order);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            
            if($form->isValid())
            {
                $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:MbTicket');
                $date = $order->getVisiteDate(); 
                //return new Response(var_dump($request)); 
                $nbTicket = $repository->getTicketNbByDate($date);
                $nbUsers = $order->getNbUsers();

                $totalTickets = $nbTicket + $nbUsers;

/*-------------------------------------------------------------------------*/
/* Disable reservation past 14h00                                          */
/*-------------------------------------------------------------------------*/
                
                $flashBag = $request->getSession()->getFlashBag();

                $renderView = 

                $onlyHalfDayService = $this->container->get('ticket_limit_management_service');
                
                if($onlyHalfDayService->getOnlyHalfDayService($order, $flashBag, $renderView) == false) 
                {
                    $flashBag->add('danger', 'Vous ne pouvez pas réserver de billet "Journée" pour ce jour après 14h');

                    goto render;
                }
                 

/*-------------------------------------------------------------------------*/
/* Reservation / day < 1000                                                */
/*-------------------------------------------------------------------------*/
                
                $maxTicketService = $this->container->get('ticket_limit_management_service');
                
                if($maxTicketService->getOnlyHalfDayService($order) == false)
                {
                    $request->getSession()->getFlashBag()->add('danger', 'Plus de places disponibles pour ce jour');

                    goto render;
                }

/*-------------------------------------------------------------------------*/
/* Price / user                                                            */
/*-------------------------------------------------------------------------*/
                foreach($order->getUsers() as $user)
                {
                    $ticket = new MbTicket();
                    $ticket->setDate($order->getVisiteDate());
                    $order->setReservationNumber(uniqid());

                    $kind = MbTicket::getKindFromBirthday($user->getBirthday(), $user->getIsReduced());

                    $ticket->setKind($kind);

                    $user->setTicket($ticket);
                }

/*-------------------------------------------------------------------------*/
/* Stripe                                                                  */
/*-------------------------------------------------------------------------*/

                $stripeService = $this->container->get('stripe_management_service');
                if($stripeService->getStripeService($order) == false)
                {
                    $request->getSession()->getFlashBag()->add('danger', 'Plus de places disponibles pour ce jour');

                    goto render;
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

/*-------------------------------------------------------------------------*/
/* Email                                                                   */
/*-------------------------------------------------------------------------*/

                $emailView = $this->renderView('Emails/registration.html.twig',array(
                    'order' => $order
                ));
                
                $emailBody = $this->renderView('Emails/registration.html.twig',array(
                    'order' => $order,
                    'logo' => 'toto'
                ));

                $mailerService = $this->container->get('mailer_management_service');
                $mailerService->getMailerService($order, $emailBody);


/*-------------------------------------------------------------------------*/
/* Message flash                                                           */
/*-------------------------------------------------------------------------*/                

                $request->getSession()->getFlashBag()->add('success', 'Vos places ont bien été réservées');
                return $this->redirectToRoute('homepage');
            }
        }

render:

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'order' => $order
        ]);
    }

    /**
     * @Route("/getUsersPrice", name="getUsersPrice", options={"expose"=true})
     * @Method({"POST"})
     */
    public function getUsersPriceAction(Request $request)
    {
        $users = json_decode($request->get('users'));

        foreach ($users as $key => $user)
        {
            $price = MbTicket::getPriceFromBirthday(new \DateTime($users[$key][2]), $users[$key][3]);
            
            array_push($users[$key], $price);
        }

        return new Response(json_encode($users));
    }
}
