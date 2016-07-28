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
     * @ORM\SequenceGenerator(sequenceName="municipio_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

   /**
     * @var \AppBundle\Entity\TecnicasPlanificacion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TecnicasPlanificacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tecnicas_planificacion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idTecnicasPlanificacion;
    
    
    /**
     * @var \AppBundle\Entity\RecursosPlanificacion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RecursosPlanificacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_recursos_planificacion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idRecursosPlanificacion;
    
    
     
    /**
     * @ORM\ManyToOne(targetEntity="PlanificacionSeccion", inversedBy="estrategia")
     * @ORM\JoinColumn(name="planificacion_seccion_id", referencedColumnName="id")
     */
    private $planificacionSeccionId;

    

    

    

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
     * Set idTecnicasPlanificacion
     *
     * @param \AppBundle\Entity\TecnicasPlanificacion $idTecnicasPlanificacion
     * @return PlanificacionSeccionEstrategia
     */
    public function setIdTecnicasPlanificacion(\AppBundle\Entity\TecnicasPlanificacion $idTecnicasPlanificacion)
    {
        $this->idTecnicasPlanificacion = $idTecnicasPlanificacion;

        return $this;
    }

    /**
     * Get idTecnicasPlanificacion
     *
     * @return \AppBundle\Entity\TecnicasPlanificacion 
     */
    public function getIdTecnicasPlanificacion()
    {
        return $this->idTecnicasPlanificacion;
    }

    /**
     * Set idRecursosPlanificacion
     *
     * @param \AppBundle\Entity\RecursosPlanificacion $idRecursosPlanificacion
     * @return PlanificacionSeccionEstrategia
     */
    public function setIdRecursosPlanificacion(\AppBundle\Entity\RecursosPlanificacion $idRecursosPlanificacion)
    {
        $this->idRecursosPlanificacion = $idRecursosPlanificacion;

        return $this;
    }

    /**
     * Get idRecursosPlanificacion
     *
     * @return \AppBundle\Entity\RecursosPlanificacion 
     */
    public function getIdRecursosPlanificacion()
    {
        return $this->idRecursosPlanificacion;
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
