<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionSeccionEstrategia
 *
 * @ORM\Table(name="planificacion_seccion_estrategia" )
 * @ORM\Entity
 */
class PlanificacionSeccionEstrategia
{
    
        
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del municipio"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="planificacion_seccion_estrategia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

  /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TecnicasPlanificacion", inversedBy="estrategia")
     * @ORM\JoinTable(name="estrategia_tecnica",
     *   joinColumns={
     *     @ORM\JoinColumn(name="estrategia_id", referencedColumnName="id", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tecnica_id", referencedColumnName="id", nullable=false)
     *   }
     * )
     */
    protected $tecnicas;
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\RecursosPlanificacion", inversedBy="estrategia")
     * @ORM\JoinTable(name="estrategia_recurso",
     *   joinColumns={
     *     @ORM\JoinColumn(name="estrategia_id", referencedColumnName="id", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="recurso_id", referencedColumnName="id", nullable=false)
     *   }
     * )
     */
    protected $recursos;
    
 
    /**
     * @ORM\ManyToOne(targetEntity="PlanificacionSeccion", inversedBy="estrategia")
     * @ORM\JoinColumn(name="planificacion_seccion_id", referencedColumnName="id")
     */
    private $planificacionSeccionId;

    
    
    
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tecnicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recursos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add tecnicas
     *
     * @param \AppBundle\Entity\TecnicasPlanificacion $tecnicas
     * @return PlanificacionSeccionEstrategia
     */
    public function addTecnica(\AppBundle\Entity\TecnicasPlanificacion $tecnicas)
    {
        $this->tecnicas[] = $tecnicas;

        return $this;
    }

    /**
     * Remove tecnicas
     *
     * @param \AppBundle\Entity\TecnicasPlanificacion $tecnicas
     */
    public function removeTecnica(\AppBundle\Entity\TecnicasPlanificacion $tecnicas)
    {
        $this->tecnicas->removeElement($tecnicas);
    }

    /**
     * Get tecnicas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTecnicas()
    {
        return $this->tecnicas;
    }

    /**
     * Add recursos
     *
     * @param \AppBundle\Entity\RecursosPlanificacion $recursos
     * @return PlanificacionSeccionEstrategia
     */
    public function addRecurso(\AppBundle\Entity\RecursosPlanificacion $recursos)
    {
        $this->recursos[] = $recursos;

        return $this;
    }

    /**
     * Remove recursos
     *
     * @param \AppBundle\Entity\RecursosPlanificacion $recursos
     */
    public function removeRecurso(\AppBundle\Entity\RecursosPlanificacion $recursos)
    {
        $this->recursos->removeElement($recursos);
    }

    /**
     * Get recursos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecursos()
    {
        return $this->recursos;
    }

    /**
     * Set planificacionSeccionId
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $planificacionSeccionId
     * @return PlanificacionSeccionEstrategia
     */
    public function setPlanificacionSeccionId(\AppBundle\Entity\PlanificacionSeccion $planificacionSeccionId = null)
    {
        $this->planificacionSeccionId = $planificacionSeccionId;

        return $this;
    }

    /**
     * Get planificacionSeccionId
     *
     * @return \AppBundle\Entity\PlanificacionSeccion 
     */
    public function getPlanificacionSeccionId()
    {
        return $this->planificacionSeccionId;
    }
}
