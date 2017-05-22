<?php

namespace lotto\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * Register
 *
 * @ORM\Table(name="register")
 * @ORM\Entity(repositoryClass="lotto\UserBundle\Repository\RegisterRepository")
 */
class Register {

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
     * @ORM\Column(name="username", type="text", unique=false)
     */
    private $username;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="registrationToken", type="text", unique=false)
     */
    private $registrationToken;
    
    /**
     * @var string
     *
     * @ORM\Column(name="hasVerifyAccount", type="boolean", unique=false)
     */
    private $hasVerifyAccount;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", unique=false)
     */
    private $password;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="text")
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="text")
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfReg", type="datetime")
     */
    private $dateOfReg;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfVerify",nullable=true, type="datetime")
     */
    private $dateOfVerify;

    /**
     * @var string
     *
     * @ORM\Column(name="path",nullable=true, type="text")
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="text")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="wallet", type="text")
     */
    private $wallet;

    /**
     * @ORM\OneToMany(targetEntity="Play_record", mappedBy="register")
     */
    protected $play_records;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="registers")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="registers")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    protected $role;

    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Register
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set dateOfReg
     *
     * @param \DateTime $dateOfReg
     *
     * @return Register
     */
    public function setDateOfReg($dateOfReg) {
        $this->dateOfReg = $dateOfReg;

        return $this;
    }

    /**
     * Get dateOfReg
     *
     * @return \DateTime
     */
    public function getDateOfReg() {
        return $this->dateOfReg;
    }


    /**
     * Set email
     *
     * @param string $email
     *
     * @return Register
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->play_records = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Register
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set wallet
     *
     * @param string $wallet
     *
     * @return Register
     */
    public function setWallet($wallet) {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Get wallet
     *
     * @return string
     */
    public function getWallet() {
        return $this->wallet;
    }

    /**
     * Add playRecord
     *
     * @param \lotto\UserBundle\Entity\Play_Record $playRecord
     *
     * @return Register
     */
    public function addPlayRecord(\lotto\UserBundle\Entity\Play_Record $playRecord) {
        $this->play_records[] = $playRecord;

        return $this;
    }

    /**
     * Remove playRecord
     *
     * @param \lotto\UserBundle\Entity\Play_Record $playRecord
     */
    public function removePlayRecord(\lotto\UserBundle\Entity\Play_Record $playRecord) {
        $this->play_records->removeElement($playRecord);
    }

    /**
     * Get playRecords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayRecords() {
        return $this->play_records;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Register
     */
    public function setFullName($fullName) {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName() {
        return $this->fullName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Register
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set country
     *
     * @param \lotto\UserBundle\Entity\Country $country
     *
     * @return Register
     */
    public function setCountry(\lotto\UserBundle\Entity\Country $country = null) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \lotto\UserBundle\Entity\Country
     */
    public function getCountry() {
        return $this->country;
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads';
    }

    public function upload() {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * Delete file from server
     * @param type $filename - The file to delete
     * @return boolean
     */
    public function deleteFile($filename) {
        //if (unlink('../web' . $filename) == TRUE) {

        if (unlink(__DIR__ . '/../../../../web/' . $filename) == TRUE) {
            return TRUE;
        }
    }


    /**
     * Set path
     *
     * @param string $path
     *
     * @return Register
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set registrationToken
     *
     * @param string $registrationToken
     *
     * @return Register
     */
    public function setRegistrationToken($registrationToken)
    {
        $this->registrationToken = $registrationToken;

        return $this;
    }

    /**
     * Get registrationToken
     *
     * @return string
     */
    public function getRegistrationToken()
    {
        return $this->registrationToken;
    }

    /**
     * Set hasVerifyAccount
     *
     * @param boolean $hasVerifyAccount
     *
     * @return Register
     */
    public function setHasVerifyAccount($hasVerifyAccount)
    {
        $this->hasVerifyAccount = $hasVerifyAccount;

        return $this;
    }

    /**
     * Get hasVerifyAccount
     *
     * @return boolean
     */
    public function getHasVerifyAccount()
    {
        return $this->hasVerifyAccount;
    }

    /**
     * Set dateOfVerify
     *
     * @param \DateTime $dateOfVerify
     *
     * @return Register
     */
    public function setDateOfVerify($dateOfVerify)
    {
        $this->dateOfVerify = $dateOfVerify;

        return $this;
    }

    /**
     * Get dateOfVerify
     *
     * @return \DateTime
     */
    public function getDateOfVerify()
    {
        return $this->dateOfVerify;
    }

    /**
     * Set role
     *
     * @param \lotto\UserBundle\Entity\Role $role
     *
     * @return Register
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
