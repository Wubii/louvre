<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\MbOrder;

class MbOTest extends TestCase
{
    const visiteDate = "21/11/2017";
    const bookingDate = "20/06/2017";
    const email = "battista.marion@gmail.com"; 
    const reservationNumber = "591859e693103"; 

    public function testOrderCreation()
    {
        $order = new MbOrder();

        $order->setVisiteDate(self::visiteDate);
        $order->setBookingDate(self::bookingDate);
        $order->setEmail(self::email);
        $order->setReservationNumber(self::reservationNumber);

        $this->assertEquals($order->getVisiteDate(), self::visiteDate);
        $this->assertEquals($order->getBookingDate(), self::bookingDate);
        $this->assertEquals($order->getEmail(), self::email);
        $this->assertEquals($order->getReservationNumber(), self::reservationNumber);
    }
}
