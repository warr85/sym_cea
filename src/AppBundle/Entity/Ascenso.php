<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Ascenso
 *
 * @ORM\Table(name="solicitud_ascenso", uniqueConstraints={@ORM\UniqueConstraint(name="ascenso_id_rol_institucion_docente_escalafones", columns={"id_rol_institucion", "id_escalafones"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Ascenso
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del Ascenso"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="adscripcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    
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
     * @var \AppBundle\Entity\Escalafones
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Escalafones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_escalafones", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idEscalafones;
    

    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "ubicacion de la constancia de trabajo"})
     *
     * @Assert\NotBlank(message="Debe cargar su constancia de Trabajo, es obligatoria.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $trabajo;
    
    
    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "ubicacion de la constancia de actualización de Expediente"})
     *
     * @Assert\NotBlank(message="debe cargar su constancia de actualización de expediente, es obligatorio.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $expediente;
    
    
    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "ubicacion de la socialización del PIDA"})
     *
     * @Assert\NotBlank(message="debe cargar su constancia de socializacion del PIDA, es obligatorio.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $pida;

    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "digital del documento aval del nucleo academico de investigacion"})
     *
     * @Assert\NotBlank(message="debe cargar su constnacia aval del NAI, es obligatorio.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $nai;

    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "digital del documento de Trabajo de investigacion"})
     *
     * @Assert\NotBlank(message="debe cargar su Trabajo de investigacion, es obligatorio.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $investigacion;
    
    
    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "ubicación del digital del informe de pertinencia en caso de ser tesis fuera de ubv"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $pertinencia;
    
    
    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "ubicación del digital del informe de pertinencia en caso de ser tesis fuera de ubv"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $aprobacion;
    
    
    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "ubicación del digital del curriculo de los posibles jurados"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $curriculo;
    
    
    
    /**
     * @ORM\Column(name="nombre_nucleo", type="string", nullable=true, options={"comment" = "Nombre del núcleo de investigación"})
     * @Assert\NotBlank(message="El nombre del núcleo de investigación es obligatorio.")
     */
    private $nombreNucelo;
    
    
    
    /**
     * @ORM\Column(name="tipo_trabajo_investigacion", type="string", nullable=true, options={"comment" = "tipo de trabajo: tesis/investigacion"})
     * @Assert\NotBlank(message="El nombre del núcleo de investigación es obligatorio.")
     */
    private $tipoTrabajoInvestigacion;
    
    
    /**
     * @ORM\Column(name="tesis_ubv", type="boolean", nullable=true, options={"comment" = "si el trabajo es una tesis, ¿esta hecha dentro de la UBV?"})
     * 
     */
    private $tesisUbv;

    
    /**
     * @ORM\Column(name="titulo_trabajo", type="string", nullable=false, options={"comment" = "titulo del trabajo de investigacion"})
     * @Assert\NotBlank(message="Titulo del Trabajo es obligatorio.")
     */
    private $tituloTrabajo;
    
    
    /**
     * @ORM\Column(name="observacion", type="string", nullable=true, options={"comment" = "titulo del trabajo de investigacion"})
     */
    private $observacion;

    
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TutoresAscenso", inversedBy="ascenso")
     * @ORM\JoinTable(name="ascenso_tutor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ascenso_id", referencedColumnName="id", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tutor_id", referencedColumnName="id", nullable=false)
     *   }
     * )
     */
    protected $tutoresAscenso;


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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set trabajo
     *
     * @param string $trabajo
     * @return Ascenso
     */
    public function setTrabajo($trabajo)
    {
        $this->trabajo = $trabajo;

        return $this;
    }

    /**
     * Get trabajo
     *
     * @return string 
     */
    public function getTrabajo()
    {
        return $this->trabajo;
    }

    /**
     * Set expediente
     *
     * @param string $expediente
     * @return Ascenso
     */
    public function setExpediente($expediente)
    {
        $this->expediente = $expediente;

        return $this;
    }

    /**
     * Get expediente
     *
     * @return string 
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Set pida
     *
     * @param string $pida
     * @return Ascenso
     */
    public function setPida($pida)
    {
        $this->pida = $pida;

        return $this;
    }

    /**
     * Get pida
     *
     * @return string 
     */
    public function getPida()
    {
        return $this->pida;
    }

    /**
     * Set nai
     *
     * @param string $nai
     * @return Ascenso
     */
    public function setNai($nai)
    {
        $this->nai = $nai;

        return $this;
    }

    /**
     * Get nai
     *
     * @return string 
     */
    public function getNai()
    {
        return $this->nai;
    }

    /**
     * Set investigacion
     *
     * @param string $investigacion
     * @return Ascenso
     */
    public function setInvestigacion($investigacion)
    {
        $this->investigacion = $investigacion;

        return $this;
    }

    /**
     * Get investigacion
     *
     * @return string 
     */
    public function getInvestigacion()
    {
        return $this->investigacion;
    }

    /**
     * Set pertinencia
     *
     * @param string $pertinencia
     * @return Ascenso
     */
    public function setPertinencia($pertinencia)
    {
        $this->pertinencia = $pertinencia;

        return $this;
    }

    /**
     * Get pertinencia
     *
     * @return string 
     */
    public function getPertinencia()
    {
        return $this->pertinencia;
    }

    /**
     * Set tituloTrabajo
     *
     * @param string $tituloTrabajo
     * @return Ascenso
     */
    public function setTituloTrabajo($tituloTrabajo)
    {
        $this->tituloTrabajo = $tituloTrabajo;

        return $this;
    }

    /**
     * Get tituloTrabajo
     *
     * @return string 
     */
    public function getTituloTrabajo()
    {
        return $this->tituloTrabajo;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Ascenso
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
     * Get fecha_ultima_actualizacion
     *
     * @return \DateTime 
     */
    public function getFechaUltimaActualizacion()
    {
        return $this->fecha_ultima_actualizacion;
    }

    /**
     * Set idRolInstitucion
     *
     * @param \AppBundle\Entity\RolInstitucion $idRolInstitucion
     * @return Ascenso
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
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return Ascenso
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
     * Set idEscalafones
     *
     * @param \AppBundle\Entity\Escalafones $idEscalafones
     * @return Ascenso
     */
    public function setIdEscalafones(\AppBundle\Entity\Escalafones $idEscalafones)
    {
        $this->idEscalafones = $idEscalafones;

        return $this;
    }

    /**
     * Get idEscalafones
     *
     * @return \AppBundle\Entity\Escalafones 
     */
    public function getIdEscalafones()
    {
        return $this->idEscalafones;
    }
    
  

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tutoresAscenso = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tutoresAscenso
     *
     * @param \AppBundle\Entity\TutoresAscenso $tutoresAscenso
     * @return Ascenso
     */
    public function addTutoresAscenso(\AppBundle\Entity\TutoresAscenso $tutoresAscenso)
    {
        $this->tutoresAscenso[] = $tutoresAscenso;

        return $this;
    }

    /**
     * Remove tutoresAscenso
     *
     * @param \AppBundle\Entity\TutoresAscenso $tutoresAscenso
     */
    public function removeTutoresAscenso(\AppBundle\Entity\TutoresAscenso $tutoresAscenso)
    {
        $this->tutoresAscenso->removeElement($tutoresAscenso);
    }

    /**
     * Get tutoresAscenso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTutoresAscenso()
    {
        return $this->tutoresAscenso;
    }
    
    /**
     * 
     * @return string
     */
    
    public function __toString() 
    {
        return $this->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerNombre();
    }

    /**
     * Set aprobacion
     *
     * @param string $aprobacion
     * @return Ascenso
     */
    public function setAprobacion($aprobacion)
    {
        $this->aprobacion = $aprobacion;

        return $this;
    }

    /**
     * Get aprobacion
     *
     * @return string 
     */
    public function getAprobacion()
    {
        return $this->aprobacion;
    }

    /**
     * Set nombreNucelo
     *
     * @param string $nombreNucelo
     * @return Ascenso
     */
    public function setNombreNucelo($nombreNucelo)
    {
        $this->nombreNucelo = $nombreNucelo;

        return $this;
    }

    /**
     * Get nombreNucelo
     *
     * @return string 
     */
    public function getNombreNucelo()
    {
        return $this->nombreNucelo;
    }

    /**
     * Set curriculo
     *
     * @param string $curriculo
     * @return Ascenso
     */
    public function setCurriculo($curriculo)
    {
        $this->curriculo = $curriculo;

        return $this;
    }

    /**
     * Get curriculo
     *
     * @return string 
     */
    public function getCurriculo()
    {
        return $this->curriculo;
    }

    /**
     * Set tipoTrabajoInvestigacion
     *
     * @param string $tipoTrabajoInvestigacion
     * @return Ascenso
     */
    public function setTipoTrabajoInvestigacion($tipoTrabajoInvestigacion)
    {
        $this->tipoTrabajoInvestigacion = $tipoTrabajoInvestigacion;

        return $this;
    }

    /**
     * Get tipoTrabajoInvestigacion
     *
     * @return string 
     */
    public function getTipoTrabajoInvestigacion()
    {
        return $this->tipoTrabajoInvestigacion;
    }

    /**
     * Set tesisUbv
     *
     * @param boolean $tesisUbv
     * @return Ascenso
     */
    public function setTesisUbv($tesisUbv)
    {
        $this->tesisUbv = $tesisUbv;

        return $this;
    }

    /**
     * Get tesisUbv
     *
     * @return boolean 
     */
    public function getTesisUbv()
    {
        return $this->tesisUbv;
    }
}
