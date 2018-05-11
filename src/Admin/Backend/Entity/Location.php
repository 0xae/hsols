<?php

namespace Admin\Backend\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="location", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Location {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ilha", type="string", length=45, nullable=false)
     */
    private $ilha;

    /**
     * @var string
     *
     * @ORM\Column(name="concelho", type="string", length=45, nullable=false)
     */
    private $concelho;
    
    /**
     * @var string
     *
     * @ORM\Column(name="localidade", type="string", length=45, nullable=false)
     */
    private $localidade;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     */
    private $createdBy;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

	public function getIlha(){
		return $this->ilha;
	}

	public function setIlha($ilha){
		$this->ilha = $ilha;
	}

	public function getConcelho(){
		return $this->concelho;
	}

	public function setConcelho($concelho){
		$this->concelho = $concelho;
	}

	public function getLocalidade(){
		return $this->localidade;
	}

	public function setLocalidade($localidade){
		$this->localidade = $localidade;
	}

	public function getCreatedAt(){
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt){
		$this->createdAt = $createdAt;
	}

	public function getCreatedBy(){
		return $this->createdBy;
	}

	public function setCreatedBy($createdBy){
		$this->createdBy = $createdBy;
    }

    public function __toString() {
        return $this->ilha . ' - ' .
        $this->concelho . ' - ' . 
        $this->localidade;
    }
}
