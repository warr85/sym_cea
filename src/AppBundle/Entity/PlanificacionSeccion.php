<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionSeccion
 *
 * @ORM\Table(name="planificacion_seccion", 
 *      uniqueConstraints=
 *          {@ORM\UniqueConstraint(name="uq_tema_uc", 
 *              columns={"id_tema_uc"})
 *          }, 
 *          indexes={ 
 *              @ORM\Index(name="fki_id_tema_uc", 
 *                  columns={"id_tema_uc"})
 *          }
 *  )
 * @ORM\Entity
 */
class PlanificacionSeccion
{
    
    /**
     * @var \AppBundle\Entity\UnidadCurricularVolumenTema
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnidadCurricularVolumenTema")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tema_uc", referencedColumnName="id", nullable=false)
     * })
     */
    private $idtemaUc;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionEspecifico", mappedBy="idObjetivoEspecifico")
     */
    private $idObjetivoEspecifico;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionContenido", mappedBy="idPlanificacionSeccionContenido")
     */
    private $idPlanificacionSeccionContenido;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionEstrategia", mappedBy="idPlanificacionSeccionEstrategia")
     */
    private $idPlanificacionSeccionEstrategia;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionEvaluacion", mappedBy="idPlanificacionSeccionEvaluacion")
     */
    private $idPlanificacionSeccionEvaluacion;
    
   
    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha de creación de la solicitud"})
    
    */
    
    private $fecha_creacion;
    
    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha de actualizacion de la solicitud"})
    
    */
    
    private $fecha_ultima_actualizacion;
    
    
     /** @var text
     *
     * @ORM\Column(name="observacion", type="text", nullable=true, options={"comment" = "Observacion de la planificacion"})
     */
    private $observacion;
    
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de las seccion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="seccion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Seccion", inversedBy="planificacion")
     * @ORM\JoinColumn(name="seccion_id", referencedColumnName="id")
     */
    private $seccion;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="objetivo", type="text", nullable=false, options={"comment" = "Objetivo de la seccion"})
     */
    private $objetivo;


  
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idObjetivoEspecifico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idPlanificacionSeccionContenido = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idPlanificacionSeccionEstrategia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idPlanificacionSeccionEvaluacion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fecha_creacion
     *
     * @param \DateTime $fechaCreacion
     * @return PlanificacionSeccion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fecha_creacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fecha_creacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Set fecha_ultima_actualizacion
     *
     * @param \DateTime $fechaUltimaActualizacion
     * @return PlanificacionSeccion
     */
    public function setFechaUltimaActualizacion($fechaUltimaActualizacion)
    {
        $this->fecha_ultima_actualizacion = $fechaUltimaActualizacion;

        return $this;
    }

    /**
     * Get fecha_ultima_actualizacion
     *
     * @return \DateTime 
     */
    public function getFechaUltimaActualizacion()
    {
        return $this->fecha_ultima_actualizacion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return PlanificacionSeccion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
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
     * Set objetivo
     *
     * @param string $objetivo
     * @return PlanificacionSeccion
     */
    public function setObjetivo($objetivo)
    {
        $this->objetivo = $objetivo;

        return $this;
    }

    /**
     * Get objetivo
     *
     * @return string 
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * Set idtemaUc
     *
     * @param \AppBundle\Entity\UnidadCurricularVolumenTema $idtemaUc
     * @return PlanificacionSeccion
     */
    public function setIdtemaUc(\AppBundle\Entity\UnidadCurricularVolumenTema $idtemaUc)
    {
        $this->idtemaUc = $idtemaUc;

        return $this;
    }

    /**
     * Get idtemaUc
     *
     * @return \AppBundle\Entity\UnidadCurricularVolumenTema 
     */
    public function getIdtemaUc()
    {
        return $this->idtemaUc;
    }

    /**
     * Add idObjetivoEspecifico
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEspecifico $idObjetivoEspecifico
     * @return PlanificacionSeccion
     */
    public function addIdObjetivoEspecifico(\AppBundle\Entity\PlanificacionSeccionEspecifico $idObjetivoEspecifico)
    {
        $this->idObjetivoEspecifico[] = $idObjetivoEspecifico;

        return $this;
    }

    /**
     * Remove idObjetivoEspecifico
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEspecifico $idObjetivoEspecifico
     */
    public function removeIdObjetivoEspecifico(\AppBundle\Entity\PlanificacionSeccionEspecifico $idObjetivoEspecifico)
    {
        $this->idObjetivoEspecifico->removeElement($idObjetivoEspecifico);
    }

    /**
     * Get idObjetivoEspecifico
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdObjetivoEspecifico()
    {
        return $this->idObjetivoEspecifico;
    }

    /**
     * Add idPlanificacionSeccionContenido
     *
     * @param \AppBundle\Entity\PlanificacionSeccionContenido $idPlanificacionSeccionContenido
     * @return PlanificacionSeccion
     */
    public function addIdPlanificacionSeccionContenido(\AppBundle\Entity\PlanificacionSeccionContenido $idPlanificacionSeccionContenido)
    {
        $this->idPlanificacionSeccionContenido[] = $idPlanificacionSeccionContenido;

        return $this;
    }

    /**
     * Remove idPlanificacionSeccionContenido
     *
     * @param \AppBundle\Entity\PlanificacionSeccionContenido $idPlanificacionSeccionContenido
     */
    public function removeIdPlanificacionSeccionContenido(\AppBundle\Entity\PlanificacionSeccionContenido $idPlanificacionSeccionContenido)
    {
        $this->idPlanificacionSeccionContenido->removeElement($idPlanificacionSeccionContenido);
    }

    /**
     * Get idPlanificacionSeccionContenido
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdPlanificacionSeccionContenido()
    {
        return $this->idPlanificacionSeccionContenido;
    }

    /**
     * Add idPlanificacionSeccionEstrategia
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEstrategia $idPlanificacionSeccionEstrategia
     * @return PlanificacionSeccion
     */
    public function addIdPlanificacionSeccionEstrategium(\AppBundle\Entity\PlanificacionSeccionEstrategia $idPlanificacionSeccionEstrategia)
    {
        $this->idPlanificacionSeccionEstrategia[] = $idPlanificacionSeccionEstrategia;

        return $this;
    }

    /**
     * Remove idPlanificacionSeccionEstrategia
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEstrategia $idPlanificacionSeccionEstrategia
     */
    public function removeIdPlanificacionSeccionEstrategium(\AppBundle\Entity\PlanificacionSeccionEstrategia $idPlanificacionSeccionEstrategia)
    {
        $this->idPlanificacionSeccionEstrategia->removeElement($idPlanificacionSeccionEstrategia);
    }

    /**
     * Get idPlanificacionSeccionEstrategia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdPlanificacionSeccionEstrategia()
    {
        return $this->idPlanificacionSeccionEstrategia;
    }

    /**
     * Add idPlanificacionSeccionEvaluacion
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEvaluacion $idPlanificacionSeccionEvaluacion
     * @return PlanificacionSeccion
     */
    public function addIdPlanificacionSeccionEvaluacion(\AppBundle\Entity\PlanificacionSeccionEvaluacion $idPlanificacionSeccionEvaluacion)
    {
        $this->idPlanificacionSeccionEvaluacion[] = $idPlanificacionSeccionEvaluacion;

        return $this;
    }

    /**
     * Remove idPlanificacionSeccionEvaluacion
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEvaluacion $idPlanificacionSeccionEvaluacion
     */
    public function removeIdPlanificacionSeccionEvaluacion(\AppBundle\Entity\PlanificacionSeccionEvaluacion $idPlanificacionSeccionEvaluacion)
    {
        $this->idPlanificacionSeccionEvaluacion->removeElement($idPlanificacionSeccionEvaluacion);
    }

    /**
     * Get idPlanificacionSeccionEvaluacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdPlanificacionSeccionEvaluacion()
    {
        return $this->idPlanificacionSeccionEvaluacion;
    }

    /**
     * Set seccion
     *
     * @param \AppBundle\Entity\Seccion $seccion
     * @return PlanificacionSeccion
     */
    public function setSeccion(\AppBundle\Entity\Seccion $seccion = null)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return \AppBundle\Entity\Seccion 
     */
    public function getSeccion()
    {
        return $this->seccion;
    }
}
