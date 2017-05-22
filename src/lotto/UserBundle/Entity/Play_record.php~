<?php

namespace lotto\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Play_record
 *
 * @ORM\Table(name="play_record")
 * @ORM\Entity(repositoryClass="lotto\UserBundle\Repository\Play_recordRepository")
 */
class Play_record
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
     * @ORM\Column(name="transactionId", type="text")
     */
    private $transactionId;
    
     
    /**
     * @var string
     *
     * @ORM\Column(name="dor", type="datetime")
     */
    private $dor;
    /**
     * @var string
     *
     * @ORM\Column(name="referenceNo", type="text")
     */
    private $referenceNo;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

     /**
    * @ORM\ManyToOne(targetEntity="Register", inversedBy="play_records")
    * @ORM\JoinColumn(name="register_id", referencedColumnName="id")
    */
    protected $register;
    
    /**
    * @ORM\ManyToOne(targetEntity="Lotto", inversedBy="play_records")
    * @ORM\JoinColumn(name="lotto_id", referencedColumnName="id")
    */
    protected $lotto;
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Play_record
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set register
     *
     * @param \lotto\UserBundle\Entity\Register $register
     *
     * @return Play_record
     */
    public function setRegister(\lotto\UserBundle\Entity\Register $register = null)
    {
        $this->register = $register;

        return $this;
    }

    /**
     * Get register
     *
     * @return \lotto\UserBundle\Entity\Register
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * Set lotto
     *
     * @param \lotto\UserBundle\Entity\Lotto $lotto
     *
     * @return Play_record
     */
    public function setLotto(\lotto\UserBundle\Entity\Lotto $lotto = null)
    {
        $this->lotto = $lotto;

        return $this;
    }

    /**
     * Get lotto
     *
     * @return \lotto\UserBundle\Entity\Lotto
     */
    public function getLotto()
    {
        return $this->lotto;
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     *
     * @return Play_record
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get transactionId
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set referenceNo
     *
     * @param string $referenceNo
     *
     * @return Play_record
     */
    public function setReferenceNo($referenceNo)
    {
        $this->referenceNo = $referenceNo;

        return $this;
    }

    /**
     * Get referenceNo
     *
     * @return string
     */
    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    /**
     * Set dor
     *
     * @param \DateTime $dor
     *
     * @return Play_record
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
}
