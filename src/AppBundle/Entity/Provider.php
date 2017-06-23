<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity()
 */
class Provider implements UserInterface, \Serializable
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_freelance", type="boolean")
     */
    private $isFreelance;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_avalaible", type="boolean")
     */
    private $isAvalaible;

    /**
     * @var ProviderType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProviderType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $providerType;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255, nullable=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="iban", type="string", length=255, nullable=true)
     */
    private $iban;

    /**
     * @var int
     *
     * @ORM\Column(name="range_distance", type="integer")
     */
    private $range;

    /**
     * Provider constructor.
     */
    public function __construct()
    {
        $this->isAvalaible = false;
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
     * Set email
     *
     * @param string $email
     *
     * @return Provider
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
     * Set password
     *
     * @param string $password
     *
     * @return Provider
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Provider
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getRoles()
    {
        return ['ROLE_PROVIDER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Provider
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isFreelance
     *
     * @param boolean $isFreelance
     *
     * @return Provider
     */
    public function setIsFreelance($isFreelance)
    {
        $this->isFreelance = $isFreelance;

        return $this;
    }

    /**
     * Get isFreelance
     *
     * @return boolean
     */
    public function getIsFreelance()
    {
        return $this->isFreelance;
    }

    /**
     * Set isAvalaible
     *
     * @param boolean $isAvalaible
     *
     * @return Provider
     */
    public function setIsAvalaible($isAvalaible)
    {
        $this->isAvalaible = $isAvalaible;

        return $this;
    }

    /**
     * Get isAvalaible
     *
     * @return boolean
     */
    public function getIsAvalaible()
    {
        return $this->isAvalaible;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return Provider
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set iban
     *
     * @param string $iban
     *
     * @return Provider
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set range
     *
     * @param integer $range
     *
     * @return Provider
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Get range
     *
     * @return integer
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Set providerType
     *
     * @param ProviderType $providerType
     *
     * @return Provider
     */
    public function setProviderType(ProviderType $providerType = null)
    {
        $this->providerType = $providerType;

        return $this;
    }

    /**
     * Get providerType
     *
     * @return ProviderType
     */
    public function getProviderType()
    {
        return $this->providerType;
    }
}
