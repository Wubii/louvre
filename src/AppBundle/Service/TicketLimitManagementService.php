<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;


class TicketLimitManagementService 
{
    public function getOnlyHalfDayService($order)
    {
        // ATTENTION toute modification de la table MbDuration doit correspondre 
        // ATTENTION "journée = 1" / "demi-journée = 2"

        if($order->getDuration()->getId() == 1)
        {
            if($order->getBookingDate()->format("Y/m/d") == $order->getVisiteDate()->format("Y/m/d"))
            {
                if(date("G:i:s", time()) >= "14:00:00")
                {
                    return false;
                }
            }
        }

        return true;
    }

    public function getNumberMaxOfTicketService($totalTickets)
    {
        if($totalTickets > 1000)
        {    
            return false;
        }

        return true;
    }
}