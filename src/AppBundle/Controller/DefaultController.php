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
        $user = new MbUser();

        $order->getUsers()->add($user);

        $form = $this->get('form.factory')->create(MbOrderType::class, $order);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            
            if($form->isValid())
            {
                $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:MbTicket');
                $date = $order->getVisiteDate();
                $nbTicket = $repository->getTicketNbByDate($date);
                $nbUsers = $order->getNbUsers();

                $totalTickets = $nbTicket + $nbUsers;

                // ATTENTION toute modification de la table MbDuration doit correspondre 
                // ATTENTION "journée = 1" / "demi-journée = 2"
                if($order->getDuration()->getId() == 2)
                {
                    if($order->getBookingDate()->format("Y/m/d") == $order->getVisiteDate()->format("Y/m/d"))
                    {
                        if(date("G:i:s", time()) >= "20:00:00")
                        {
                            $request->getSession()->getFlashBag()->add('danger', 'Vous ne pouvez pas réserver de billet "Journée" pour ce jour après 14h');
                        
                            return $this->render('default/index.html.twig', [
                                'form' => $form->createView(),
                                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
                            ]);
                        }
                    }
                }

                // remplacer 1000 par const
                if($totalTickets > 1000)
                {
                    $request->getSession()->getFlashBag()->add('danger', 'Plus de places disponibles pour ce jour');
                    
                    return $this->render('default/index.html.twig', [
                        'form' => $form->createView(),
                        'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
                    ]);
                }

                foreach($order->getUsers() as $user)
                {
                    $ticket = new MbTicket();
                    $ticket->setDate($order->getVisiteDate());
                    $order->setReservationNumber(uniqid());

                    // Pour vérifier un booléen, on le compare toujours à 0/false
                    // pas de convention qui dit que vrai = 1
                    if($user->getIsReduced() != 0)
                    {
                        $ticket->setKind(MbTicket::TICKET_KIND_REDUCED);
                    }
                    else
                    {
                        $currentDate = new \DateTime('now');
                        $dateInterval = $currentDate->diff($user->getBirthday());
                        $age = $dateInterval->format('%y');

                        if($age <= 4)
                        {
                            $ticket->setKind(MbTicket::TICKET_KIND_BABY);
                        }
                        else if($age <= 12)
                        {
                            $ticket->setKind(MbTicket::TICKET_KIND_CHILD);
                        }
                        else if($age < 60)
                        {
                            $ticket->setKind(MbTicket::TICKET_KIND_NORMAL);
                        }
                        else
                        {
                            $ticket->setKind(MbTicket::TICKET_KIND_SENIOR);
                        }
                    }

                    $user->setTicket($ticket);
                }

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

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                $emailView = $this->renderView('Emails/registration.html.twig',array(
                        'order' => $order)
                );

                //return new Response($emailView);

                $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
                  ->setUsername('wubii.wu')
                  ->setPassword('wwemmorgbsphwxuq')
                ;

                $mailer = \Swift_Mailer::newInstance($transport);

                // $logger = new \Swift_Plugins_Loggers_EchoLogger();
                // $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));


                $message = \Swift_Message::newInstance('Wonderful Subject')
                  ->setFrom(array('wubii.wu@gmail.com' => 'Louvre'))
                  ->setSubject('Vos billets pour le Louvre')
                  ->setTo(array($order->getEmail()))
                  ->setBody(
                      $this->renderView('Emails/registration.html.twig',array(
                        'order' => $order,
                        'logo' => 'toto')
                      ),
                      'text/html'
                    );

                // Send the message
                $result = $mailer->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Vos places ont bien été réservées');
                return $this->redirectToRoute('homepage');
            }
        }

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
    public function getUsersPriceAction($users, Request $request){
        return new Response('blabla');
    }
}
