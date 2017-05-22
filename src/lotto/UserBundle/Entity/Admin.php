<?php

namespace lotto\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity(repositoryClass="lotto\UserBundle\Repository\AdminRepository")
 */
class Admin
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
     * @ORM\Column(name="username", type="text")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="text")
     */
    private $fullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dor", type="datetime")
     */
    private $dor;
    
     /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="admins")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    protected $role;


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
     * Set username
     *
     * @param string $username
     *
     * @return Admin
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Admin
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
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Admin
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set dor
     *
     * @param \DateTime $dor
     *
     * @return Admin
     */
    public function setDor($dor)
    {
        $this->dor = $dor;

        return $this;
    }

    /**
     * Get dor
     *
     * @return \DateTime
     */
    public function getDor()
    {
        return $this->dor;
    }

    /**
     * Set role
     *
     * @param \lotto\UserBundle\Entity\Role $role
     *
     * @return Admin
     */
    public function setRole(\lotto\UserBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \lotto\UserBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
