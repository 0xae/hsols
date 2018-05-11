<?php

namespace Admin\Backend\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="correction", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Correction {
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
     * @ORM\Column(name="source", type="string", length=45, nullable=false)
     */
    private $source;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="IReclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ireclamation_id", referencedColumnName="id", nullable=true)
     * })
     * 
     */
    private $irecl;

    /**
     * @var string
     *
     * @ORM\Column(name="action_description", type="string", length=255, nullable=false)
     */
    private $actionDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="action_type", type="string", length=255, nullable=false)
     */
    private $actionType;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="action_author", referencedColumnName="id", nullable=false)
     * })
     */
     private $actionAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="action_date", type="date", nullable=false)
     */
    private $actionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="cause_description", type="string", length=255, nullable=false)
     */
    private $causeDescription;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cause_resp", referencedColumnName="id", nullable=false)
     * })
     */
    private $causeResp;

    /**
     * @var string
     *
     * @ORM\Column(name="cause_date", type="date", nullable=false)
     */    
    private $causeDate;

    /**
     * \ImplMeasure
     */
    private $implObjs;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="impl_resp", referencedColumnName="id", nullable=true)
     * })
     */
    private $implResp;

    /**
     * @var string
     *
     * @ORM\Column(name="impl_date", type="date", nullable=true)
     */    
    private $implDate;

    /**
     * @var string
     *
     * @ORM\Column(name="close_finished", type="boolean", nullable=true)
    */    
    private $closeFinished;

    /**
     * @var string
     *
     * @ORM\Column(name="close_date2", type="date", nullable=true)
    */  
    private $closeDate2;

        /**
     * @var string
     *
     * @ORM\Column(name="close_eficacy", type="boolean", nullable=true)
    */    
    private $closeEficacy;

    /**
     * @var string
     *
     * @ORM\Column(name="close_action", type="string", length=255, nullable=false)
     */
    private $closeAction;
    
    /**
     * @var string
     *
     * @ORM\Column(name="close_in_date", type="date", nullable=true)
    */ 
    private $closeInDate;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="close_resp", referencedColumnName="id", nullable=true)
     * })
     */
    private $closeResp;

    /**
     * @var string
     *
     * @ORM\Column(name="close_date", type="date", nullable=true)
    */ 
    private $closeDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date", nullable=false)
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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="measure", type="text", nullable=true)
     */
    private $measure;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="date", nullable=true)
     */
    private $dueDate;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function getMeasure(){
		return $this->measure;
	}

	public function setMeasure($measure){
		$this->measure = $measure;
	}

	public function getDueDate(){
		return $this->dueDate;
	}

	public function setDueDate($dueDate){
		$this->dueDate = $dueDate;
	}

	public function getImplResp(){
		return $this->implResp;
	}

	public function setImplResp($implResp){
		$this->implResp = $implResp;
	}

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Category
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
     * @return Category
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

    public function getSource(){
		return $this->source;
	}

	public function setSource($source){
		$this->source = $source;
	}

	public function getIrecl(){
		return $this->irecl;
	}

	public function setIrecl($irecl){
		$this->irecl = $irecl;
	}

	public function getActionDescription(){
		return $this->actionDescription;
	}

	public function setActionDescription($actionDescription){
		$this->actionDescription = $actionDescription;
	}

	public function getActionType(){
		return $this->actionType;
	}

	public function setActionType($actionType){
		$this->actionType = $actionType;
	}

	public function getActionAuthor(){
		return $this->actionAuthor;
	}

	public function setActionAuthor($actionAuthor){
		$this->actionAuthor = $actionAuthor;
	}

	public function getActionDate(){
		return $this->actionDate;
	}

	public function setActionDate($actionDate){
		$this->actionDate = $actionDate;
	}

	public function getCauseDescription(){
		return $this->causeDescription;
	}

	public function setCauseDescription($causeDescription){
		$this->causeDescription = $causeDescription;
	}

	public function getCauseResp(){
		return $this->causeResp;
	}

	public function setCauseResp($causeResp){
		$this->causeResp = $causeResp;
	}

	public function getCauseDate(){
		return $this->causeDate;
	}

	public function setCauseDate($causeDate){
		$this->causeDate = $causeDate;
	}

	public function getImplObjs(){
		return $this->implObjs;
	}

	public function setImplObjs($implObjs){
		$this->implObjs = $implObjs;
	}

	public function getImplDate(){
		return $this->implDate;
	}

	public function setImplDate($implDate){
		$this->implDate = $implDate;
	}

	public function getCloseFinished(){
		return $this->closeFinished;
	}

	public function setCloseFinished($closeFinished){
		$this->closeFinished = $closeFinished;
	}

	public function getCloseDate2(){
		return $this->closeDate2;
	}

	public function setCloseDate2($closeDate2){
		$this->closeDate2 = $closeDate2;
	}

	public function getCloseEficacy(){
		return $this->closeEficacy;
	}

	public function setCloseEficacy($closeEficacy){
		$this->closeEficacy = $closeEficacy;
	}

	public function getCloseAction(){
		return $this->closeAction;
	}

	public function setCloseAction($closeAction){
		$this->closeAction = $closeAction;
	}

	public function getCloseInDate(){
		return $this->closeInDate;
	}

	public function setCloseInDate($closeInDate){
		$this->closeInDate = $closeInDate;
	}

	public function getCloseResp(){
		return $this->closeResp;
	}

	public function setCloseResp($closeResp){
		$this->closeResp = $closeResp;
	}

	public function getCloseDate(){
		return $this->closeDate;
	}

	public function setCloseDate($closeDate){
		$this->closeDate = $closeDate;
	}
}
