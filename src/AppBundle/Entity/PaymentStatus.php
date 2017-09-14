<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentStatus
 *
 * @ORM\Table(name="payment_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentStatusRepository")
 */
class PaymentStatus
{
    // PENDING is set when an order is created
    const PENDING = 'PENDING';

    // UNCAPTURED is set when an order is accepted by a provider
    const UNCAPTURED = 'UNCAPTURED';

    // UNPAID is set when an order (paymentType == cash) is accepted by a provider
    const UNPAID = 'UNPAID';

    // PAID is set when a provider has received his money
    const PAID = 'PAID';

    // CAPTURED is set when an order is completed by a customer
    const CAPTURED = 'CAPTURED';

    // CANCELLED is set when an order is cancelled by a provider
    const CANCELLED = 'CANCELLED';

    // FAILED is set when a payment has failed on Stripe
    const FAILED = 'FAILED';

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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     */
    private $code;

    /**
     * PaymentStatus constructor.
     * @param $code
     * @param $label
     */
    public function __construct($code, $label)
    {
        $this->code = $code;
        $this->label = $label;
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
     * Set label
     *
     * @param string $label
     *
     * @return PaymentStatus
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return PaymentStatus
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
