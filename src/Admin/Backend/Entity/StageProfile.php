<?php

namespace Admin\Backend\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppEntity
 *
 * @ORM\Table(name="stage_profile", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class StageProfile {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ModuleStage
     *
     * @ORM\ManyToOne(targetEntity="ModuleStage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_stage_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $moduleStage;

    /**
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $profile;

    private $module;

    public function getModule() {
        return $this->module;
    }

    public function setModule($value) {
        $this->module = $value;
    }

    public function getProfile() {
        return $this->profile;
    }

    public function setProfile($value) {
        $this->profile = $value;
    }

    public function getModuleStage() {
        return $this->moduleStage;
    }

    public function setModuleStage($value) {
        $this->moduleStage = $value;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

}
