<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity()
 */
class Orders
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
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var OrderStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrderStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderStatus;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;

    /**
     * @var Catalog
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Catalog")
     * @ORM\JoinColumn(nullable=false)
     */
    private $catalog;


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
     * Set address
     *
     * @param string $address
     *
     * @return Orders
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set orderStatus
     *
     * @param \AppBundle\Entity\OrderStatus $orderStatus
     *
     * @return Orders
     */
    public function setOrderStatus(\AppBundle\Entity\OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    /**
     * Get orderStatus
     *
     * @return \AppBundle\Entity\OrderStatus
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Orders
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set catalog
     *
     * @param \AppBundle\Entity\Catalog $catalog
     *
     * @return Orders
     */
    public function setCatalog(\AppBundle\Entity\Catalog $catalog)
    {
        $this->catalog = $catalog;

        return $this;
    }

    /**
     * Get catalog
     *
     * @return \AppBundle\Entity\Catalog
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * Set provider
     *
     * @param \AppBundle\Entity\Provider $provider
     *
     * @return Orders
     */
    public function setProvider(\AppBundle\Entity\Provider $provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \AppBundle\Entity\Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
