<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MbPayment
 *
 * @ORM\Table(name="mb_payment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MbPaymentRepository")
 */
class MbPayment
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
     * @var int
     *
     * @ORM\Column(name="cardNumber", type="integer")
     */
    private $cardNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="cardCVC", type="integer")
     */
    private $cardCVC;

    /**
     * @var \int
     *
     * @ORM\Column(name="cardExpiryMonth", type="integer")
     */
    private $cardExpiryMonth;

    /**
     * @var \int
     *
     * @ORM\Column(name="cardExpiryYear", type="integer")
     */
    private $cardExpiryYear;

    /**
     * @var string
     *
     * @ORM\Column(name="stripeToken", type="string", length=255)
     */
    private $stripeToken;


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
     * Set cardNumber
     *
     * @param integer $cardNumber
     *
     * @return MbPayment
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
     * Set cardCVC
     *
     * @param integer $cardCVC
     *
     * @return MbPayment
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

    /**
     * Set cardExpiryMonth
     *
     * @param \DateTime $cardExpiryMonth
     *
     * @return MbPayment
     */
    public function setCardExpiryMonth($cardExpiryMonth)
    {
        $this->cardExpiryMonth = $cardExpiryMonth;

        return $this;
    }

    /**
     * Get cardExpiryMonth
     *
     * @return \DateTime
     */
    public function getCardExpiryMonth()
    {
        return $this->cardExpiryMonth;
    }

    /**
     * Set cardExpiryYear
     *
     * @param \DateTime $cardExpiryYear
     *
     * @return MbPayment
     */
    public function setCardExpiryYear($cardExpiryYear)
    {
        $this->cardExpiryYear = $cardExpiryYear;

        return $this;
    }

    /**
     * Get cardExpiryYear
     *
     * @return \DateTime
     */
    public function getCardExpiryYear()
    {
        return $this->cardExpiryYear;
    }

    /**
     * Set stripeToken
     *
     * @param string $stripeToken
     *
     * @return MbPayment
     */
    public function setStripeToken($stripeToken)
    {
        $this->stripeToken = $stripeToken;

        return $this;
    }

    /**
     * Get stripeToken
     *
     * @return string
     */
    public function getStripeToken()
    {
        return $this->stripeToken;
    }
}

