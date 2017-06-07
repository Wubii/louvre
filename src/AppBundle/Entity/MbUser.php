<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * MbUser
 *
 * @ORM\Table(name="mb_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MbUserRepository")
 */
class MbUser
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
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @var int
     *
     * @ORM\Column(name="isReduced", type="smallint")
     */
    private $isReduced;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * One User have One ticket.
     * @ORM\OneToOne(targetEntity="MbTicket", cascade={"persist"})
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    private $ticket;

    public function __construct()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->birthday = new \DateTime('now');
        $this->country = 'none';
        $this->ticket = null;
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return MbUser
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return MbUser
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return MbUser
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set isReduced
     *
     * @param \DateTime $isReduced
     *
     * @return MbUser
     */
    public function setIsReduced($isReduced)
    {
        $this->isReduced = $isReduced;

        return $this;
    }

    /**
     * Get isReduced
     *
     * @return \DateTime
     */
    public function getIsReduced()
    {
        return $this->isReduced;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return MbUser
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set ticket
     *
     * @param object $ticket
     *
     * @return MbUser
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return object
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}

