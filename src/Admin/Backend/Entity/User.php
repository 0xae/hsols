<?php

namespace Admin\Backend\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="entity", columns={"entity"})})
 * @ORM\Entity
 */
class User extends BaseUser {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="integer", nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=45, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_dir", type="string", length=100, nullable=true)
     */
    private $photoDir;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     * })
     * 
     */
     private $createdBy;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
    */
    private $isActive;

    /**
     * @var \Admin\Backend\Entity\Profile
     *
     * @ORM\ManyToOne(targetEntity="Admin\Backend\Entity\Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     * })
     */
    private $profile;

    /**
     * @var \Admin\Backend\Entity\AppEntity
     *
     * @ORM\ManyToOne(targetEntity="Admin\Backend\Entity\AppEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entity", referencedColumnName="id")
     * })
     */
    private $entity;

    /**
     * @ORM\Column(name="context", type="string", length=100, nullable=true)
     */
    private $context;    

    private $passwordConf;

    public function __construct() {
        parent::__construct();
        $this->createdAt = new \DateTime();
    }

    public function isActive(){
		return $this->isActive;
	}

	public function setIsActive($val){
		$this->isActive = $val;
	}

    public function getContext(){
		return $this->context;
	}

	public function setContext($context){
		$this->context = $context;
	}    

    public function getProfile(){
		return $this->profile;
	}

	public function setProfile($profile){
		$this->profile = $profile;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set phone
     *
     * @param integer $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
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
     * Set photoDir
     *
     * @param string $photoDir
     * @return User
     */
    public function setPhotoDir($photoDir)
    {
        $this->photoDir = $photoDir;

        return $this;
    }

    /**
     * Get photoDir
     *
     * @return string 
     */
    public function getPhotoDir()
    {
        return $this->photoDir;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     * @return User
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
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
     * Set entity
     *
     * @param \Admin\Backend\Entity\AppEntity $entity
     * @return User
     */
    public function setEntity(\Admin\Backend\Entity\AppEntity $entity = null)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return \Admin\Backend\Entity\AppEntity 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    public function getPasswordConf(){
		return $this->passwordConf;
	}

	public function setPasswordConf($passwordConf){
		$this->passwordConf = $passwordConf;
	}
}
