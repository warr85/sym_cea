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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\RolInstitucion", inversedBy="adscripcion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idRolInstitucion;


    
    /** @ORM\Column(type="date", nullable=false, options={"comment" = "Fecha de de Ingreso a la Institucion"})  
     /**
     * @Assert\Date()
     * @Assert\NotBlank()(groups={"Oposicion"})
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
     * @ORM\Column(name="titulo_trabajo", type="string", nullable=true, options={"comment" = "titulo del trabajo de investigacion"})
     */
    private $tituloTrabajo;
    
    
    /**
     * @ORM\Column(name="ano_adscripcion", type="integer", nullable=true, options={"comment" = "El número de profesor nos permitirá saber la cantidad de profesores adscritos al CEA por eje geopolítico y desde cuando"})
     */
    private $anoAdscripcion;
    
    
    /**
     * @ORM\Column(name="correlativo_adscripcion", type="integer", nullable=true, options={"comment" = "El número de profesor nos permitirá saber la cantidad de profesores adscritos al CEA por eje geopolítico y desde cuando"})
     */
    private $correlativoAdscripcion;
    

    
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
     * Set anoAdscripcion
     *
     * @param string $anoAdscripcion
     * @return Adscripcion
     */
    public function setAnoAdscripcion($anoAdscripcion)
    {
        $this->anoAdscripcion = $anoAdscripcion;

        return $this;
    }

    /**
     * Get anoAdscripcion
     *
     * @return string 
     */
    public function getAnoAdscripcion()
    {
        return $this->anoAdscripcion;
    }

    /**
     * Set correlativoAdscripcion
     *
     * @param integer $correlativoAdscripcion
     * @return Adscripcion
     */
    public function setCorrelativoAdscripcion($correlativoAdscripcion)
    {
        $this->correlativoAdscripcion = $correlativoAdscripcion;

        return $this;
    }

    /**
     * Get correlativoAdscripcion
     *
     * @return integer 
     */
    public function getCorrelativoAdscripcion()
    {
        return $this->correlativoAdscripcion;
    }

    /**
     * Set idRolInstitucion
     *
     * @param \AppBundle\Entity\RolInstitucion $idRolInstitucion
     * @return Adscripcion
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
}
