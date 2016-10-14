<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * AdscripcionPida
 *
 * @ORM\Table(name="solicitud_pida", uniqueConstraints={@ORM\UniqueConstraint(name="pida_id_rol_institucion_key", columns={"id_rol_institucion"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AdscripcionPida
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la AdscripcionPida"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="adscripcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="objetivo_especifico", type="text", nullable=false, options={"comment" = "objetivo especifico a desarrollar dentro enmarcado en el plan patria"})
     */
    private $objetivoEspecifico;
    
    
    
	/**
     * @var \AppBundle\Entity\RolInstitucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RolInstitucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idRolInstitucion;
    
    

    /**
     * @var \AppBundle\Entity\PlanHistoricoNacionalEstrategico
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlanHistoricoNacionalEstrategico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_plan_historico_nacional_estrategico", referencedColumnName="id", nullable=true)
     * })
     */
    protected $idPlanHistoricoNacionalEstrategico;
    
    
    /**
     * @var \AppBundle\Entity\ActividadDocente
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ActividadDocente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_actividad_docente", referencedColumnName="id", nullable=true)
     * })
     */
    protected $idActividadDocente;
    
    
     /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha de inicio de la activdad PIDA"})
    
    */
    
    private $fecha_inicio;
    
    
     /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha de fin de la actividad"})
    
    */
    
    private $fecha_final;
   
    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha de creación de la solicitud"})
    
    */
    
    private $fecha_creacion;
    
    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha de actualizacion de la solicitud"})
    
    */
    
    private $fecha_ultima_actualizacion;
    
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
     * Set idRolInstitucion
     *
     * @param \AppBundle\Entity\RolInstitucion $idRolInstitucion
     * @return Usuarios
     */
    public function setIdRolInstitucion(\AppBundle\Entity\RolInstitucion $idRolInstitucion = null)
    {
        $this->idRolInstitucion = $idRolInstitucion;

        return $this;
    }

    /**
     * Get idRolInstitucion
     *
     * @return \AppBundle\Entity\RolInstitucion
     */
    public function getIdRolInstitucion()
    {
        return $this->idRolInstitucion;
    }

 
    
    
    
    /**
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return Estatus
     */
    public function setIdEstatus(\AppBundle\Entity\Estatus $idEstatus = null)
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
   * @ORM\PrePersist
   */
    public function setFechaCreacion()
    {
	    $this->fecha_creacion = new \DateTime();
	    $this->fecha_ultima_actualizacion = new \DateTime();
    }
    
     public function getFechaCreacion()
    {
	   return $this->fecha_creacion;
	   
    }
    

    /**
    * @ORM\PreUpdate
    */
    public function setFechaUltimaActualizacion()
    {
        $this->fecha_utlima_actualizacion = new \DateTime();
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
     * Set idPlanHistoricoNacionalEstrategico
     *
     * @param \AppBundle\Entity\PlanHistoricoNacionalEstrategico $idPlanHistoricoNacionalEstrategico
     * @return AdscripcionPida
     */
    public function setIdPlanHistoricoNacionalEstrategico(\AppBundle\Entity\PlanHistoricoNacionalEstrategico $idPlanHistoricoNacionalEstrategico = null)
    {
        $this->idPlanHistoricoNacionalEstrategico = $idPlanHistoricoNacionalEstrategico;

        return $this;
    }

    /**
     * Get idPlanHistoricoNacionalEstrategico
     *
     * @return \AppBundle\Entity\PlanHistoricoNacionalEstrategico 
     */
    public function getIdPlanHistoricoNacionalEstrategico()
    {
        return $this->idPlanHistoricoNacionalEstrategico;
    }

    /**
     * Set idActividadDocente
     *
     * @param \AppBundle\Entity\ActividadDocente $idActividadDocente
     * @return AdscripcionPida
     */
    public function setIdActividadDocente(\AppBundle\Entity\ActividadDocente $idActividadDocente = null)
    {
        $this->idActividadDocente = $idActividadDocente;

        return $this;
    }

    /**
     * Get idActividadDocente
     *
     * @return \AppBundle\Entity\ActividadDocente 
     */
    public function getIdActividadDocente()
    {
        return $this->idActividadDocente;
    }

    /**
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return AdscripcionPida
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fecha_inicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set fecha_final
     *
     * @param \DateTime $fechaFinal
     * @return AdscripcionPida
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fecha_final = $fechaFinal;

        return $this;
    }

    /**
     * Get fecha_final
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fecha_final;
    }

    /**
     * Set objetivoEspecifico
     *
     * @param string $objetivoEspecifico
     * @return AdscripcionPida
     */
    public function setObjetivoEspecifico($objetivoEspecifico)
    {
        $this->objetivoEspecifico = $objetivoEspecifico;

        return $this;
    }

    /**
     * Get objetivoEspecifico
     *
     * @return string 
     */
    public function getObjetivoEspecifico()
    {
        return $this->objetivoEspecifico;
    }
}
