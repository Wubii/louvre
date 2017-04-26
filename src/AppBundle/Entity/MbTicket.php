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
     * @ORM\Column(name="sort", type="string", length=255)
     */
    private $sort;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="smallint")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="idNunber", type="string", length=255)
     */
    private $idNunber;


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
     * Set sort
     *
     * @param string $sort
     *
     * @return MbTicket
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return MbTicket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set idNunber
     *
     * @param string $idNunber
     *
     * @return MbTicket
     */
    public function setIdNunber($idNunber)
    {
        $this->idNunber = $idNunber;

        return $this;
    }

    /**
     * Get idNunber
     *
     * @return string
     */
    public function getIdNunber()
    {
        return $this->idNunber;
    }
}

