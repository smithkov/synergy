<?php

namespace lotto\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lotto
 *
 * @ORM\Table(name="lotto")
 * @ORM\Entity(repositoryClass="lotto\UserBundle\Repository\LottoRepository")
 */
class Lotto
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
     * @ORM\Column(name="code", type="text")
     */
    private $code;
    
    /**
     * @var string
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
    
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfCreation", type="datetime")
     */
    private $dateOfCreation;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="text", precision=10, scale=0)
     */
    private $price;
    
   /**
    * @ORM\OneToMany(targetEntity="Play_record", mappedBy="register")
    */
    protected $play_records;


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
     * @return Lotto
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
     * Set price
     *
     * @param string $price
     *
     * @return Lotto
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->play_records = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add playRecord
     *
     * @param \lotto\UserBundle\Entity\Play_Record $playRecord
     *
     * @return Lotto
     */
    public function addPlayRecord(\lotto\UserBundle\Entity\Play_Record $playRecord)
    {
        $this->play_records[] = $playRecord;

        return $this;
    }

    /**
     * Remove playRecord
     *
     * @param \lotto\UserBundle\Entity\Play_Record $playRecord
     */
    public function removePlayRecord(\lotto\UserBundle\Entity\Play_Record $playRecord)
    {
        $this->play_records->removeElement($playRecord);
    }

    /**
     * Get playRecords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayRecords()
    {
        return $this->play_records;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Lotto
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

    /**
     * Set dateOfCreation
     *
     * @param \DateTime $dateOfCreation
     *
     * @return Lotto
     */
    public function setDateOfCreation($dateOfCreation)
    {
        $this->dateOfCreation = $dateOfCreation;

        return $this;
    }

    /**
     * Get dateOfCreation
     *
     * @return \DateTime
     */
    public function getDateOfCreation()
    {
        return $this->dateOfCreation;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Lotto
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Lotto
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Lotto
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
