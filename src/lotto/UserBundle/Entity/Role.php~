<?php

namespace lotto\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="lotto\UserBundle\Repository\RoleRepository")
 */
class Role
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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    
    /**
     * @ORM\OneToMany(targetEntity="Register", mappedBy="role")
     */
    protected $registers;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin", mappedBy="role")
     */
    protected $admins;

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
     * Set name
     *
     * @param string $name
     *
     * @return Role
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
     * Set description
     *
     * @param string $description
     *
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->admins = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add register
     *
     * @param \lotto\UserBundle\Entity\Register $register
     *
     * @return Role
     */
    public function addRegister(\lotto\UserBundle\Entity\Register $register)
    {
        $this->registers[] = $register;

        return $this;
    }

    /**
     * Remove register
     *
     * @param \lotto\UserBundle\Entity\Register $register
     */
    public function removeRegister(\lotto\UserBundle\Entity\Register $register)
    {
        $this->registers->removeElement($register);
    }

    /**
     * Get registers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegisters()
    {
        return $this->registers;
    }

    /**
     * Add admin
     *
     * @param \lotto\UserBundle\Entity\Admin $admin
     *
     * @return Role
     */
    public function addAdmin(\lotto\UserBundle\Entity\Admin $admin)
    {
        $this->admins[] = $admin;

        return $this;
    }

    /**
     * Remove admin
     *
     * @param \lotto\UserBundle\Entity\Admin $admin
     */
    public function removeAdmin(\lotto\UserBundle\Entity\Admin $admin)
    {
        $this->admins->removeElement($admin);
    }

    /**
     * Get admins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdmins()
    {
        return $this->admins;
    }
}
