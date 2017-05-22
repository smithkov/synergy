<?php

namespace lotto\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountInfo
 *
 * @ORM\Table(name="account_info")
 * @ORM\Entity(repositoryClass="lotto\UserBundle\Repository\AccountInfoRepository")
 */
class AccountInfo
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
     * @ORM\Column(name="wallet", type="string", length=255)
     */
    private $wallet;
    
    /**
     * @var string
     *
     * @ORM\Column(name="isActive", type="boolean", length=255)
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set wallet
     *
     * @param string $wallet
     *
     * @return AccountInfo
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Get wallet
     *
     * @return string
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AccountInfo
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return AccountInfo
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
