<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\MbTicket;

class MbTicketTest extends TestCase
{
    const kind = "Battista";
    const date = "20/05/2017";

    public function testTicketCreation()
    {
        $ticket = new MbTicket();

        $ticket->setKind(self::kind);
        $ticket->setDate(self::date);

        $this->assertEquals($ticket->getKind(), self::kind);
        $this->assertEquals($ticket->getDate(), self::date);
    }
}
