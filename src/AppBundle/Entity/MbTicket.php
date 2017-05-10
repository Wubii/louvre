<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MbTicket
 *
 * @ORM\Table(name="mb_ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MbTicketRepository")
 */
class MbTicket
{
    const TICKET_KIND_BABY    = 1;
    const TICKET_KIND_CHILD   = 2;
    const TICKET_KIND_NORMAL  = 3;
    const TICKET_KIND_SENIOR  = 4;
    const TICKET_KIND_REDUCED = 5;

    const TICKET_KIND_BABY_NAME    = "Enfant de moins de quatre ans";
    const TICKET_KIND_CHILD_NAME   = "Enfant";
    const TICKET_KIND_NORMAL_NAME  = "Normal";
    const TICKET_KIND_SENIOR_NAME  = "Adulte <60";
    const TICKET_KIND_REDUCED_NAME = "Réduit";

    const TICKET_KIND_BABY_PRICE    = 0;
    const TICKET_KIND_CHILD_PRICE   = 8;
    const TICKET_KIND_NORMAL_PRICE  = 16;
    const TICKET_KIND_SENIOR_PRICE  = 12;
    const TICKET_KIND_REDUCED_PRICE = 10;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="kind", type="integer")
     */
    private $kind;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set kind
     *
     * @param string $kind
     *
     * @return MbTicket
     */
    public function setKind($kind)
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * Get kind
     *
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        $price = 0;

        switch ($this->kind) {
            case TICKET_KIND_BABY:
                $price = TICKET_KIND_BABY_PRICE;
                break;

            case TICKET_KIND_CHILD:
                $price = TICKET_KIND_CHILD_PRICE;
                break;

            case TICKET_KIND_NORMAL:
                $price = TICKET_KIND_NORMAL_PRICE;
                break;

            case TICKET_KIND_SENIOR:
                $price = TICKET_KIND_SENIOR_PRICE;
                break;

            case TICKET_KIND_REDUCED:
                $price = TICKET_KIND_REDUCED_PRICE;
                break;
            
            default:
                $price = TICKET_KIND_NORMAL_PRICE;
                break;
        }
        return $price;
    }

    /**
     * Get name
     *
     * @return int
     */
    public function getName()
    {
        $name = 0;

        switch ($this->kind) {
            case TICKET_KIND_BABY:
                $name = TICKET_KIND_BABY_NAME;
                break;

            case TICKET_KIND_CHILD:
                $name = TICKET_KIND_CHILD_NAME;
                break;

            case TICKET_KIND_NORMAL:
                $name = TICKET_KIND_NORMAL_NAME;
                break;

            case TICKET_KIND_SENIOR:
                $name = TICKET_KIND_SENIOR_NAME;
                break;

            case TICKET_KIND_REDUCED:
                $name = TICKET_KIND_REDUCED_NAME;
                break;
            
            default:
                $name = TICKET_KIND_NORMAL_NAME;
                break;
        }
        return $name;
    }


    /**
     * Get idNumber
     *
     * @return string
     */
    public function getTicketNumber()
    {
        return strval($this->id);
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return MbTicket
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

