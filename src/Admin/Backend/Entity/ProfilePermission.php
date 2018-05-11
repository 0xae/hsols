<?php

namespace Admin\Backend\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProfilePermission
 *
 * @ORM\Table(name="profile_permission", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class ProfilePermission {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string action url (ex: administration_CompBook, administration_CompBook_index)
     *
     * @ORM\Column(name="permission", type="string", length=45, nullable=false)
     */
    private $permission;

    /**
     * @var string 
     *
     * @ORM\Column(name="permission_label", type="string", length=45, nullable=true)
     */    
    private $permissionLabel;    

    /**
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $profile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     */
    private $createdBy;

    public function getProfile() {
        return $this->profile;
    }

    public function setProfile($value) {
        $this->profile = $value;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return AppEntity
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     * @return AppEntity
     */
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer 
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set permission
     *
     * @param string $permission
     * @return Profile
     */
    public function setPermission($permission) {
        $this->permission = $permission;
        return $this;
    }

    /**
     * Get permission
     *
     * @return string 
     */
    public function getPermission() {
        return $this->permission;
    }

    public function setPermissionLabel($value) {
        $this->permissionLabel = $value;
        return $this;
    }

    public function getPermissionLabel() {
        return $this->permissionLabel;
    }    
}
