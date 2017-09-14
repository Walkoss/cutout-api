<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentRepository")
 */
class Payment
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
     * @var PaymentStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentStatus;

    /**
     * @var PaymentStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentType;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="charge_id", nullable=true, length=255)
     */
    private $chargeId;

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
     * Set paymentStatus
     *
     * @param \AppBundle\Entity\PaymentStatus $paymentStatus
     *
     * @return Payment
     */
    public function setPaymentStatus(\AppBundle\Entity\PaymentStatus $paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return \AppBundle\Entity\PaymentStatus
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Orders $order
     *
     * @return Payment
     */
    public function setOrder(\AppBundle\Entity\Orders $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Orders
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set paymentType
     *
     * @param \AppBundle\Entity\PaymentType $paymentType
     *
     * @return Payment
     */
    public function setPaymentType(\AppBundle\Entity\PaymentType $paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return \AppBundle\Entity\PaymentType
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set chargeId
     *
     * @param string $chargeId
     *
     * @return Payment
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    /**
     * Get chargeId
     *
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }
}
