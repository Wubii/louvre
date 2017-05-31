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
        return self::getPriceFromKind($this->kind);
    }

    /**
     * Get name
     *
     * @return int
     */
    public function getName()
    {
        return self::getNameFromKind($this->kind);
    }


    /**
     * Get idNumber
     *
     * @return string
     */
    public function getTicketNumber()
    {
        return "LVMBCS" . sprintf("%06d", $this->id);
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

    static public function getKindFromBirthday($date, $isReduced)
    {
        $result = MbTicket::TICKET_KIND_NORMAL;
        
        if($isReduced != 0)
        {
            $result = MbTicket::TICKET_KIND_REDUCED;
        }
        else
        {
            $currentDate = new \DateTime('now');
            $dateInterval = $currentDate->diff($date);
            $age = $dateInterval->format('%y');

            if($age <= 4)
            {
                $result = MbTicket::TICKET_KIND_BABY;
            }
            else if($age <= 12)
            {
                $result = MbTicket::TICKET_KIND_CHILD;
            }
            else if($age < 60)
            {
                $result = MbTicket::TICKET_KIND_NORMAL;
            }
            else
            {
                $result = MbTicket::TICKET_KIND_SENIOR;
            }
        }

        return $result;
    }
    
    static public function getPriceFromBirthday($date, $isReduced)
    {
        $kind = self::getKindFromBirthday($date, $isReduced);

        return self::getPriceFromKind($kind);
    }

    /**
     * Get name
     *
     * @return int
     */
    static public function getNameFromKind($kind)
    {
        $name = "";

        switch ($kind) {
            case self::TICKET_KIND_BABY:
                $name = self::TICKET_KIND_BABY_NAME;
                break;

            case self::TICKET_KIND_CHILD:
                $name = self::TICKET_KIND_CHILD_NAME;
                break;

            case self::TICKET_KIND_NORMAL:
                $name = self::TICKET_KIND_NORMAL_NAME;
                break;

            case self::TICKET_KIND_SENIOR:
                $name = self::TICKET_KIND_SENIOR_NAME;
                break;

            case self::TICKET_KIND_REDUCED:
                $name = self::TICKET_KIND_REDUCED_NAME;
                break;
            
            default:
                $name = self::TICKET_KIND_NORMAL_NAME;
                break;
        }
        return $name;
    }

    /**
     * Get price
     *
     * @return int
     */
    static public function getPriceFromKind($kind)
    {
        $price = 0;

        switch ($kind) {
            case self::TICKET_KIND_BABY:
                $price = self::TICKET_KIND_BABY_PRICE;
                break;

            case self::TICKET_KIND_CHILD:
                $price = self::TICKET_KIND_CHILD_PRICE;
                break;

            case self::TICKET_KIND_NORMAL:
                $price = self::TICKET_KIND_NORMAL_PRICE;
                break;

            case self::TICKET_KIND_SENIOR:
                $price = self::TICKET_KIND_SENIOR_PRICE;
                break;

            case self::TICKET_KIND_REDUCED:
                $price = self::TICKET_KIND_REDUCED_PRICE;
                break;
            
            default:
                $price = self::TICKET_KIND_NORMAL_PRICE;
                break;
        }

        return $price;
    }
}

