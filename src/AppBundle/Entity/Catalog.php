<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalog
 *
 * @ORM\Table(name="catalog")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatalogRepository")
 */
class Catalog
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
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var CatalogType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CatalogType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $catalogType;

    /**
     * @var GenderType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GenderType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genderType;

    /**
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider", inversedBy="catalogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;

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
     * Set price
     *
     * @param float $price
     *
     * @return Catalog
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set catalogType
     *
     * @param CatalogType $catalogType
     *
     * @return Catalog
     */
    public function setCatalogType(CatalogType $catalogType)
    {
        $this->catalogType = $catalogType;

        return $this;
    }

    /**
     * Get catalogType
     *
     * @return CatalogType
     */
    public function getCatalogType()
    {
        return $this->catalogType;
    }

    /**
     * Set genderType
     *
     * @param GenderType $genderType
     *
     * @return Catalog
     */
    public function setGenderType(GenderType $genderType)
    {
        $this->genderType = $genderType;

        return $this;
    }

    /**
     * Get genderType
     *
     * @return GenderType
     */
    public function getGenderType()
    {
        return $this->genderType;
    }

    /**
     * Set provider
     *
     * @param Provider $provider
     *
     * @return Catalog
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
