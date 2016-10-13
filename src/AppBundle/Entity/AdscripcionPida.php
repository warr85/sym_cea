<?php
/**
 * Created by PhpStorm.
 * User: Wilmer Ramones
 * Date: 29/06/16
 * Time: 07:52 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Adscripcion
 *
 * @ORM\Table(name="solicitud_adscripcion", uniqueConstraints={@ORM\UniqueConstraint(name="adscripcion_id_rol_institucion_key", columns={"id_rol_institucion"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Adscripcion
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la Adscripcion"})
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
    
    /** @ORM\Column(type="date", nullable=false, options={"comment" = "Fecha de de Ingreso a la Institucion"})  
     /**
     * @Assert\Date()
     */      
    private $fecha_ingreso;


    /**
     * @var \AppBundle\Entity\LineasInvestigacion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LineasInvestigacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_linea_investigacion", referencedColumnName="id", nullable=true)
     * })
     */
    protected $idLineaInvestigacion;

    
    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "ubicacion de la constancia de trabajo"})
     *
     * @Assert\NotBlank(message="Debe cargar su constancia de Trabajo, es obligatoria.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $trabajo;
    
    
    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "ubicacion del titulo de pregrado"})
     *
     * @Assert\NotBlank(message="debe cargar su título de pregrado en digital, es obligatorio.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $pregrado;
    
    
    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "ubicacion del titulo de postgrado en caso de tenerlo"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $postgrado;

    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "digital del documento de aprobación del concurso de oposicion"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $oposicion;

    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "digital del documento de ascenso de Asistente"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $asistente;

    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "digital del documento de ascenso de Asociado"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $asociado;




    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "digital del documento de ascenso de agregado"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $agreado;


    /**
     * @ORM\Column(type="string", nullable=true, options={"comment" = "digital del documento de ascenso de titular"})
     *
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $titular;



    /**
     * @ORM\Column(name="titulo_trabajo", type="string", nullable=true, options={"comment" = "titulo del trabajo de investigacion"})
     */
    private $tituloTrabajo;

    
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
    
       
    
    

    public function getTrabajo()
    {
        return $this->trabajo;
    }

    public function setTrabajo($trabajo)
    {
        $this->trabajo = $trabajo;

        return $this;
    }
    
    public function getPregrado()
    {
        return $this->pregrado;
    }

    public function setPregrado($pregrado)
    {
        $this->pregrado = $pregrado;

        return $this;
    }
    
    public function getPostgrado()
    {
        return $this->postgrado;
    }

    public function setPostgrado($postgrado)
    {
        $this->postgrado = $postgrado;

        return $this;
    }

    public function getAsistente()
    {
        return $this->asistente;
    }

    public function setAsistente($asistente)
    {
        $this->asistente = $asistente;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOposicion()
    {
        return $this->oposicion;
    }

    /**
     * @param mixed $oposicion
     */
    public function setOposicion($oposicion)
    {
        $this->oposicion = $oposicion;
    }

    /**
     * @return mixed
     */
    public function getAsociado()
    {
        return $this->asociado;
    }

    /**
     * @param mixed $asociado
     */
    public function setAsociado($asociado)
    {
        $this->asociado = $asociado;
    }

    /**
     * @return mixed
     */
    public function getAgreado()
    {
        return $this->agreado;
    }

    /**
     * @param mixed $agreado
     */
    public function setAgreado($agreado)
    {
        $this->agreado = $agreado;
    }

    /**
     * @return mixed
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * @param mixed $titular
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;
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
     * Set idLineaInvestigacion
     *
     * @param \AppBundle\Entity\LineasInvestigacion $idLineaInvestigacion
     * @return LineasInvestigacion
     */
    public function setIdLineaInvestigacion(\AppBundle\Entity\LineasInvestigacion $idLineaInvestigacion = null)
    {
        $this->idLineaInvestigacion = $idLineaInvestigacion;

        return $this;
    }

    /**
     * Get idLineaIvestigacion
     *
     * @return \AppBundle\Entity\LineasInvestigacion
     */
    public function getIdLineaInvestigacion()
    {
        return $this->idLineaInvestigacion;
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
     * @return mixed
     */
    public function getTituloTrabajo()
    {
        return $this->tituloTrabajo;
    }


    /**
     * @param mixed $tituloTrabajo
     */
        public function setTituloTrabajo($tituloTrabajo)
        {
            $this->tituloTrabajo = $tituloTrabajo;
        }
    
    
        /**
        * Set fecha_escala
        *
        * @param \DateTime $fecha_escala
        * @return Comment
        */
       public function setFechaIngreso($fecha_ingreso)
       {
           $this->fecha_ingreso = $fecha_ingreso;

           return $this;
       }

       /**
        * Get fecha_escala
        *
        * @return \DateTime
        */
       public function getFechaIngreso()
       {
           return $this->fecha_ingreso;
       }


}
