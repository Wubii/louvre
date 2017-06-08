<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * MbOrder
 *
 * @ORM\Table(name="mb_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MbOrderRepository")
 */
class MbOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visiteDate", type="date")
     * @Assert\Date
     */
    private $visiteDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookingDate", type="datetime")
     * @Assert\Date
     */
    private $bookingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true)
     */
    private $email;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="MbUser", cascade={"persist"})
     * @ORM\JoinTable(name="mb_order_mb_user",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="reservationNumber", type="string")
     */
    private $reservationNumber;

    /**
     * Many orders have One duration.
     * @ORM\ManyToOne(targetEntity="MbDuration", cascade={"persist"})
     * @ORM\JoinColumn(name="duration_id", referencedColumnName="id")
     */
    private $duration;
    
    private $cardNumber;

    private $cardMonth;

    private $cardYear;

    private $cardCVC;

    public function __construct()
    {
        $this->visiteDate = new \DateTime('now');
        $this->bookingDate = new \DateTime('now');
        $this->email = "empty";
        $this->users = new ArrayCollection();
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
     * Set visiteDate
     *
     * @param \DateTime $visiteDate
     *
     * @return MbOrder
     */
    public function setVisiteDate($visiteDate)
    {
        $this->visiteDate = $visiteDate;

        return $this;
    }

    /**
     * Get visiteDate
     *
     * @return \DateTime
     */
    public function getVisiteDate()
    {
        return $this->visiteDate;
    }

    /**
     * Set bookingDate
     *
     * @param \DateTime $bookingDate
     *
     * @return MbOrder
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return \DateTime
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return MbOrder
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set users
     *
     * @param integer $users
     *
     * @return MbOrder
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return int
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function getNbUsers()
    {
        return count($this->users);
    }

    /**
     * Set reservationNumber
     *
     * @param integer $reservationNumber
     *
     * @return MbOrder
     */
    public function setReservationNumber($reservationNumber)
    {
        $this->reservationNumber = $reservationNumber;

        return $this;
    }

    /**
     * Get reservationNumber
     *
     * @return int
     */
    public function getReservationNumber()
    {
        return $this->reservationNumber;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return MbOrder
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    public function getPrice()
    {
        $price = 0;

        foreach ($this->users as $user)
        {
            $price += $user->getTicket()->getPrice();
        }

        return $price;
    }

    /**
     * Set cardNumber
     *
     * @param integer $cardNumber
     *
     * @return MbOrder
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return int
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set cardMonth
     *
     * @param integer $cardMonth
     *
     * @return MbOrder
     */
    public function setCardMonth($cardMonth)
    {
        $this->cardMonth = $cardMonth;

        return $this;
    }

    /**
     * Get cardMonth
     *
     * @return int
     */
    public function getCardMonth()
    {
        return $this->cardMonth;
    }

    /**
     * Set cardYear
     *
     * @param integer $cardYear
     *
     * @return MbOrder
     */
    public function setCardYear($cardYear)
    {
        $this->cardYear = $cardYear;

        return $this;
    }

    /**
     * Get cardYear
     *
     * @return int
     */
    public function getCardYear()
    {
        return $this->cardYear;
    }

    /**
     * Set cardCVC
     *
     * @param integer $cardCVC
     *
     * @return MbOrder
     */
    public function setCardCVC($cardCVC)
    {
        $this->cardCVC = $cardCVC;

        return $this;
    }

    /**
     * Get cardCVC
     *
     * @return int
     */
    public function getCardCVC()
    {
        return $this->cardCVC;
    }
}

