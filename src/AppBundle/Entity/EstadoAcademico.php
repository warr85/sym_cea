<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Inscripcion;

/**
 * EstadoAcademico
 *
 * @ORM\Table(name="estado_academico", uniqueConstraints={@ORM\UniqueConstraint(name="i_rol_institucion_oferta_malla", columns={"id_rol_institucion", "id_oferta_malla_curricular"})}, indexes = {@ORM\Index(name="fki_docente_servicio_estado_academico", columns={"id_docente_servicio"}), @ORM\Index(name="fki_grado_academico_estado_academico", columns={"id_grado_academico"}), @ORM\Index(name="fki_oferta_malla_curricular_estado_academico", columns={"id_oferta_malla_curricular"}), @ORM\Index(name="fki_rol_institucion_estado_academico", columns={"id_rol_institucion"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class EstadoAcademico
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false, options={"comment" = "fecha de registro del estdo academico"})
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true, options={"comment" = "observacion del registro"})
     */
    private $observacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del estado academico"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="estado_academico_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\DocenteServicio
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DocenteServicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_docente_servicio", referencedColumnName="id", nullable=false)
     * })
     */
    private $idDocenteServicio;

    /**
     * @var \AppBundle\Entity\RolInstitucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RolInstitucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idRolInstitucion;

    
    /**
     * @var \AppBundle\Entity\MallaCurricular
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OfertaMallaCurricular")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_oferta_malla_curricular", referencedColumnName="id", nullable=false)
     * })
     */
    private $idOfertaMallaCurricular;

    /**
     * @var \AppBundle\Entity\GradoAcademico
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GradoAcademico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_grado_academico", referencedColumnName="id",nullable=false)
     * })
     */
    private $idGradoAcademico;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Inscripcion", mappedBy="idEstadoAcademico", cascade={"all"})
     * */
    protected $hasInscripcion;
    
    private $idSeccion;

   
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idSeccion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hasInscripcion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fecha = new \DateTime();
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return EstadoAcademico
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return EstadoAcademico
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
     * Set idDocenteServicio
     *
     * @param \AppBundle\Entity\DocenteServicio $idDocenteServicio
     * @return EstadoAcademico
     */
    public function setIdDocenteServicio(\AppBundle\Entity\DocenteServicio $idDocenteServicio)
    {
        $this->idDocenteServicio = $idDocenteServicio;

        return $this;
    }

    /**
     * Get idDocenteServicio
     *
     * @return \AppBundle\Entity\DocenteServicio 
     */
    public function getIdDocenteServicio()
    {
        return $this->idDocenteServicio;
    }

    /**
     * Set idRolInstitucion
     *
     * @param \AppBundle\Entity\RolInstitucion $idRolInstitucion
     * @return EstadoAcademico
     */
    public function setIdRolInstitucion(\AppBundle\Entity\RolInstitucion $idRolInstitucion)
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
     * Set idOfertaMallaCurricular
     *
     * @param \AppBundle\Entity\OfertaMallaCurricular $idOfertaMallaCurricular
     * @return EstadoAcademico
     */
    public function setIdOfertaMallaCurricular(\AppBundle\Entity\OfertaMallaCurricular $idOfertaMallaCurricular)
    {
        $this->idOfertaMallaCurricular = $idOfertaMallaCurricular;

        return $this;
    }

    /**
     * Get idOfertaMallaCurricular
     *
     * @return \AppBundle\Entity\OfertaMallaCurricular 
     */
    public function getIdOfertaMallaCurricular()
    {
        return $this->idOfertaMallaCurricular;
    }

    /**
     * Set idGradoAcademico
     *
     * @param \AppBundle\Entity\GradoAcademico $idGradoAcademico
     * @return EstadoAcademico
     */
    public function setIdGradoAcademico(\AppBundle\Entity\GradoAcademico $idGradoAcademico)
    {
        $this->idGradoAcademico = $idGradoAcademico;

        return $this;
    }

    /**
     * Get idGradoAcademico
     *
     * @return \AppBundle\Entity\GradoAcademico 
     */
    public function getIdGradoAcademico()
    {
        return $this->idGradoAcademico;
    }

    /**
     * Add hasInscripcion
     *
     * @param \AppBundle\Entity\Inscripcion $hasInscripcion
     * @return EstadoAcademico
     */
    public function addHasInscripcion(\AppBundle\Entity\Inscripcion $hasInscripcion)
    {
        $this->hasInscripcion[] = $hasInscripcion;

        return $this;
    }

    /**
     * Remove hasInscripcion
     *
     * @param \AppBundle\Entity\Inscripcion $hasInscripcion
     */
    public function removeHasInscripcion(\AppBundle\Entity\Inscripcion $hasInscripcion)
    {
        $this->hasInscripcion->removeElement($hasInscripcion);
    }

    /**
     * Get hasInscripcion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHasInscripcion()
    {
        return $this->hasInscripcion;
    }
    
    
     /**
     * Get idOfertaAcademica
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdSeccion()
    {
        $idSeccion = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach($this->hasInscripcion as $inscrita)
        {
            $idSeccion[] = $inscrita->getIdSeccion();
        }

        return $idSeccion;
    }
   
    
    /**
     * Set idSeccion
     *
     */
    public function setIdSeccion($idSeccion, $estatus)
    {
        
            $inscripcion = new Inscripcion();            
            $inscripcion->setIdEstadoAcademico($this);
            $inscripcion->setIdSeccion($idSeccion);
            $inscripcion->setIdEstatus($estatus);
            $this->addHasInscripcion($inscripcion);            
        

    }
}
