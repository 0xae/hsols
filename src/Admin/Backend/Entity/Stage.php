<?php

namespace Admin\Backend\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppEntity
 *
 * @ORM\Table(name="stage", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Stage {
    const ACOMPANHAMENTO='acompanhamento';
    const TRATAMENTO='tratamento';
    const ACEITADO='aceitado';
    const REJEITADO='rejeitado';
    const RESPONDIDO='respondido';
    const SEM_RESPOSTA='sem_resposta';
    const FAVORABLE='favoravel';
    const NO_FAVORABLE='nao_favoravel';
    const NO_COMP='sem_competencia';
    const NO_CONFOR='nao_conformidade';

    const ANALYSIS='analysis';
    const ACTION='action';
    const DECISION='decision';
    const CONCLUDED='concluded';

    public static function format($state) {
        if ($state == self::ACOMPANHAMENTO) {
            return 'Acompanhamento';
        } else if ($state == self::TRATAMENTO) {
            return 'Tratamento';
        } else if ($state == self::ACEITADO) {
            return 'Aceite';
        } else if ($state == self::REJEITADO) {
            return 'Rejeitado';
        } else if ($state == self::RESPONDIDO) {
            return 'Respondido';
        } else if ($state == self::SEM_RESPOSTA) {
            return 'Sem resposta';
        } else if ($state == self::FAVORABLE) {
            return 'Favoravel';
        } else if ($state == self::NO_FAVORABLE) {
            return 'Não favoravel';           
        } else if ($state == self::NO_COMP) {
            return 'Competência de terceiros';            
        } else if ($state == self::NO_CONFOR) {            
            return 'Não Conformidades';
        } else if ($state == self::ANALYSIS) {
            return 'Análise';
        } else if ($state == self::ACTION) {
            return 'Ação';
        } else if ($state == self::DECISION) {
            return 'Decisão';
        } else if ($state == self::CONCLUDED) {
            return 'Concluida';
        } else {
            return $state;
        }
    }

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
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="bigint", nullable=false)
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

    /**
     * Set name
     *
     * @param string $name
     * @return AppEntity
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
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
}
