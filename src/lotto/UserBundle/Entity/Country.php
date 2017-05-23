<?php

namespace lotto\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="lotto\UserBundle\Repository\CountryRepository")
 */
class Country {

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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="text")
     */
    private $code;
    
    /**
     * @var string
     *
     * @ORM\Column(name="isd_code", type="text")
     */
    private $isd_code;

    /**
     * @ORM\OneToMany(targetEntity="Register", mappedBy="country")
     */
    protected $registers;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Country
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Country
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->registers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add register
     *
     * @param \lotto\UserBundle\Entity\Register $register
     *
     * @return Country
     */
    public function addRegister(\lotto\UserBundle\Entity\Register $register) {
        $this->registers[] = $register;

        return $this;
    }

    /**
     * Remove register
     *
     * @param \lotto\UserBundle\Entity\Register $register
     */
    public function removeRegister(\lotto\UserBundle\Entity\Register $register) {
        $this->registers->removeElement($register);
    }

    /**
     * Get registers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegisters() {
        return $this->registers;
    }


    /**
     * Set isdCode
     *
     * @param string $isdCode
     *
     * @return Country
     */
    public function setIsdCode($isdCode)
    {
        $this->isd_code = $isdCode;

        return $this;
    }

    /**
     * Get isdCode
     *
     * @return string
     */
    public function getIsdCode()
    {
        return $this->isd_code;
    }
}
