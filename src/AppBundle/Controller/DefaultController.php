<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
                //Vérifier qu'il reste des places
                //Aller chercher tous les tickets de la date souhaitée par l'utilisateur
                //Si le total des ticket + le nb de ticket de l'user est supérieur à 1000
                //Alors la réservation n'est pas possible
                //sinon foreach

                $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:MbTicket');
                $date = $order->getVisiteDate();
                
                $nbTicket = $repository->getTicketNbByDate($date);
                $nbUsers = $order->getNbUsers();

                $totalTickets = $nbTicket + $nbUsers;

                if($totalTickets > 2)
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

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'Vos places ont bien été réservées');
                return $this->redirectToRoute('homepage');
            }
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
