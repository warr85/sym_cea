<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlanificacionSeccionEvaluacion
 *
 * @ORM\Table(name="planificacion_seccion_evaluacion", 
 *      uniqueConstraints=
 *          {@ORM\UniqueConstraint(name="uq_planificacion_seccion", 
 *              columns={"id_planificacion_seccion"})
 *          }, 
 *          indexes={ 
 *              @ORM\Index(name="fki_id_planificacion_evaluacion", 
 *                  columns={"id_planificacion_seccion"})
 *          }
 *  )
 * @ORM\Entity
 */
class PlanificacionSeccionEvaluacion
{
    
    /**
     * @var \AppBundle\Entity\PlanificacionSeccion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlanificacionSeccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_planificacion_seccion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPlanificacionSeccion;
    
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
     * @var text
     *
     * @ORM\Column(name="tipo_instrumento_evaluacion", type="text", nullable=false, options={"comment" = "Instrumentos para la evaluacion"})
     */
    private $tipoInstrumentoEvaluacion;
    
    
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
     * Set idPlanificacionSeccion
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $idPlanificacionSeccion
     * @return PlanificacionSeccionEvaluacion
     */
    public function setIdPlanificacionSeccion(\AppBundle\Entity\PlanificacionSeccion $idPlanificacionSeccion)
    {
        $this->idPlanificacionSeccion = $idPlanificacionSeccion;

        return $this;
    }

    /**
     * Get idPlanificacionSeccion
     *
     * @return \AppBundle\Entity\PlanificacionSeccion 
     */
    public function getIdPlanificacionSeccion()
    {
        return $this->idPlanificacionSeccion;
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
}
