<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlanificacionSeccionEvaluacion
 *
 * @ORM\Table(name="planificacion_seccion_evaluacion")
 * @ORM\Entity
 */
class PlanificacionSeccionEvaluacion
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
     * @var \AppBundle\Entity\TipoEvaluacion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoEvaluacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_evaluacion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idTipoEvaluacion;
    
    
   /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TipoInstrumentoEvaluacion", inversedBy="evaluacion")
     * @ORM\JoinTable(name="evaluacion_instrumento",
     *   joinColumns={
     *     @ORM\JoinColumn(name="evaluacion_id", referencedColumnName="id", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="instrumento_id", referencedColumnName="id", nullable=false)
     *   }
     * )
     */
    protected $instrumentos;
    
    
    /**
     * @Assert\Range(
     *      min = 1,
     *      max = 25,
     *      minMessage = "debe crear una ponderacion de minimo 1%",
     *      maxMessage = "Segun reglamento, no puede exeder de 25%"
     * )
     * @var integer
     *
     * @ORM\Column(name="ponderacion", type="integer", nullable=false, options={"comment" = "Porcentaje de la evaluacion"})
     */
     protected $ponderacion;
     
     
     /** 
      * @ORM\Column(name="fecha_evaluacion", type="datetime", nullable=false, options={"comment" = "Fecha de creación de la solicitud"})
      *
      * @var date     
    */
    
    private $fechaEvaluacion;
    
    
    /**
     * @var \AppBundle\Entity\Estatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idEstatus;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="PlanificacionSeccion", inversedBy="evaluacion")
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
     * Set tipoInstrumentoEvaluacion
     *
     * @param string $tipoInstrumentoEvaluacion
     * @return PlanificacionSeccionEvaluacion
     */
    public function setTipoInstrumentoEvaluacion($tipoInstrumentoEvaluacion)
    {
        $this->tipoInstrumentoEvaluacion = $tipoInstrumentoEvaluacion;

        return $this;
    }

    /**
     * Get tipoInstrumentoEvaluacion
     *
     * @return string 
     */
    public function getTipoInstrumentoEvaluacion()
    {
        return $this->tipoInstrumentoEvaluacion;
    }

    /**
     * Set ponderacion
     *
     * @param integer $ponderacion
     * @return PlanificacionSeccionEvaluacion
     */
    public function setPonderacion($ponderacion)
    {
        $this->ponderacion = $ponderacion;

        return $this;
    }

    /**
     * Get ponderacion
     *
     * @return integer 
     */
    public function getPonderacion()
    {
        return $this->ponderacion;
    }

    /**
     * Set fechaEvaluacion
     *
     * @param \DateTime $fechaEvaluacion
     * @return PlanificacionSeccionEvaluacion
     */
    public function setFechaEvaluacion($fechaEvaluacion)
    {
        $this->fechaEvaluacion = $fechaEvaluacion;

        return $this;
    }

    /**
     * Get fechaEvaluacion
     *
     * @return \DateTime 
     */
    public function getFechaEvaluacion()
    {
        return $this->fechaEvaluacion;
    }

    

    /**
     * Set idTipoEvaluacion
     *
     * @param \AppBundle\Entity\TipoEvaluacion $idTipoEvaluacion
     * @return PlanificacionSeccionEvaluacion
     */
    public function setIdTipoEvaluacion(\AppBundle\Entity\TipoEvaluacion $idTipoEvaluacion)
    {
        $this->idTipoEvaluacion = $idTipoEvaluacion;

        return $this;
    }

    /**
     * Get idTipoEvaluacion
     *
     * @return \AppBundle\Entity\TipoEvaluacion 
     */
    public function getIdTipoEvaluacion()
    {
        return $this->idTipoEvaluacion;
    }

    /**
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return PlanificacionSeccionEvaluacion
     */
    public function setIdEstatus(\AppBundle\Entity\Estatus $idEstatus)
    {
        $this->idEstatus = $idEstatus;

        return $this;
    }

    /**
     * Get idEstatus
     *
     * @return \AppBundle\Entity\Estatus 
     */
    public function getIdEstatus()
    {
        return $this->idEstatus;
    }

    /**
     * Set idPlanificacionEvaluacion
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $idPlanificacionEvaluacion
     * @return PlanificacionSeccionEvaluacion
     */
    public function setIdPlanificacionEvaluacion(\AppBundle\Entity\PlanificacionSeccion $idPlanificacionEvaluacion = null)
    {
        $this->idPlanificacionEvaluacion = $idPlanificacionEvaluacion;

        return $this;
    }

    /**
     * Get idPlanificacionEvaluacion
     *
     * @return \AppBundle\Entity\PlanificacionSeccion 
     */
    public function getIdPlanificacionEvaluacion()
    {
        return $this->idPlanificacionEvaluacion;
    }

    /**
     * Set planificacionSeccionId
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $planificacionSeccionId
     * @return PlanificacionSeccionEvaluacion
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instrumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add instrumentos
     *
     * @param \AppBundle\Entity\TipoInstrumentoEvaluacion $instrumentos
     * @return PlanificacionSeccionEvaluacion
     */
    public function addInstrumento(\AppBundle\Entity\TipoInstrumentoEvaluacion $instrumentos)
    {
        $this->instrumentos[] = $instrumentos;

        return $this;
    }

    /**
     * Remove instrumentos
     *
     * @param \AppBundle\Entity\TipoInstrumentoEvaluacion $instrumentos
     */
    public function removeInstrumento(\AppBundle\Entity\TipoInstrumentoEvaluacion $instrumentos)
    {
        $this->instrumentos->removeElement($instrumentos);
    }

    /**
     * Get instrumentos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInstrumentos()
    {
        return $this->instrumentos;
    }
}
