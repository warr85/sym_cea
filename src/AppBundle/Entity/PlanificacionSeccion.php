<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionSeccion
 *
 * @ORM\Table(name="planificacion_seccion", 
 *      uniqueConstraints=
 *          {@ORM\UniqueConstraint(name="uq_tema_uc_seccion", 
 *              columns={"id_tema_uc", "seccion_id"})
 *          }, 
 *          indexes={ 
 *              @ORM\Index(name="fki_id_tema_uc", 
 *                  columns={"id_tema_uc"})
 *          }
 *  )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class PlanificacionSeccion
{
    
    /**
     * @var \AppBundle\Entity\UnidadCurricularVolumenTema
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnidadCurricularVolumenTema", inversedBy="hasPlanificacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tema_uc", referencedColumnName="id", nullable=false)
     * })
     */
    private $idtemaUc;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionEspecifico", mappedBy="planificacionSeccionId",cascade={"all"})
     * @var \Doctrine\Common\Collections\ArrayCollection     
     */
    private $objetivoEspecifico;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionContenido", mappedBy="planificacionSeccionId", cascade={"all"})
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $contenido;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionEstrategia", mappedBy="idPlanificacionEstrategia")
     */
    private $estrategia;
    
    
    /**
     * @ORM\OneToMany(targetEntity="PlanificacionSeccionEvaluacion", mappedBy="idPlanificacionEvaluacion")
     */
    private $evaluacion;
    
   
    
    /** @ORM\Column(name="fecha_creacion", type="datetime", nullable=false, options={"comment" = "Fecha de creación de la solicitud"})
    
    */
    
    private $fechaCreacion;
    
    
    /** @ORM\Column(name="fecha_ultima_actualizacion", type="datetime", nullable=false, options={"comment" = "Fecha de actualizacion de la solicitud"})
    
    */
    
    private $fechaUltimaActualizacion;
    
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->objetivoEspecifico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contenido = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estrategia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evaluacion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add contenido
     *
     * @param \AppBundle\Entity\PlanificacionSeccionContenido $contenido
     * @return PlanificacionSeccion
     */
    public function addContenido(\AppBundle\Entity\PlanificacionSeccionContenido $contenido)
    {
        $contenido->setPlanificacionSeccionId($this);
        $this->contenido[] = $contenido;
        

        return $this;
    }

    /**
     * Remove contenido
     *
     * @param \AppBundle\Entity\PlanificacionSeccionContenido $contenido
     */
    public function removeContenido(\AppBundle\Entity\PlanificacionSeccionContenido $contenido)
    {
        $this->contenido->removeElement($contenido);
    }

    /**
     * Get contenido
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Add estrategia
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEstrategia $estrategia
     * @return PlanificacionSeccion
     */
    public function addEstrategium(\AppBundle\Entity\PlanificacionSeccionEstrategia $estrategia)
    {
        $this->estrategia[] = $estrategia;

        return $this;
    }

    /**
     * Remove estrategia
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEstrategia $estrategia
     */
    public function removeEstrategium(\AppBundle\Entity\PlanificacionSeccionEstrategia $estrategia)
    {
        $this->estrategia->removeElement($estrategia);
    }

    /**
     * Get estrategia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEstrategia()
    {
        return $this->estrategia;
    }

    /**
     * Add evaluacion
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEvaluacion $evaluacion
     * @return PlanificacionSeccion
     */
    public function addEvaluacion(\AppBundle\Entity\PlanificacionSeccionEvaluacion $evaluacion)
    {
        $this->evaluacion[] = $evaluacion;

        return $this;
    }

    /**
     * Remove evaluacion
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEvaluacion $evaluacion
     */
    public function removeEvaluacion(\AppBundle\Entity\PlanificacionSeccionEvaluacion $evaluacion)
    {
        $this->evaluacion->removeElement($evaluacion);
    }

    /**
     * Get evaluacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvaluacion()
    {
        return $this->evaluacion;
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

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->fechaCreacion = new \DateTime();
        $this->fechaUltimaActualizacion = new \DateTime();
    }
    
    
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->fechaUltimaActualizacion = new \DateTime();
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }


    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return PlanificacionSeccion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Set fechaUltimaActualizacion
     *
     * @param \DateTime $fechaUltimaActualizacion
     * @return PlanificacionSeccion
     */
    public function setFechaUltimaActualizacion($fechaUltimaActualizacion)
    {
        $this->fechaUltimaActualizacion = $fechaUltimaActualizacion;

        return $this;
    }

    /**
     * Get fechaUltimaActualizacion
     *
     * @return \DateTime 
     */
    public function getFechaUltimaActualizacion()
    {
        return $this->fechaUltimaActualizacion;
    }

    /**
     * Add objetivoEspecifico
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEspecifico $objetivoEspecifico
     * @return PlanificacionSeccion
     */
    public function addObjetivoEspecifico(\AppBundle\Entity\PlanificacionSeccionEspecifico $objetivoEspecifico)
    {
        $this->objetivoEspecifico[] = $objetivoEspecifico;

        return $this;
    }

    /**
     * Remove objetivoEspecifico
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEspecifico $objetivoEspecifico
     */
    public function removeObjetivoEspecifico(\AppBundle\Entity\PlanificacionSeccionEspecifico $objetivoEspecifico)
    {
        $this->objetivoEspecifico->removeElement($objetivoEspecifico);
    }

    /**
     * Get objetivoEspecifico
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjetivoEspecifico()
    {
        return $this->objetivoEspecifico;
    }
}
