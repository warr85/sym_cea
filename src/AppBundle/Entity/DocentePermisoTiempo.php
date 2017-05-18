<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * DocentePermisoTiempo
 *
 * @ORM\Table(name="docente_permiso_tiempo")
 * @ORM\Entity
 */
class DocentePermisoTiempo
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
     * @var \AppBundle\Entity\DocenteServicio
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DocenteServicio", inversedBy="docentePermisoTiempo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_docente_servicio", referencedColumnName="id", nullable=true)
     * })
     */
    protected $idDocenteServicio;


   
    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha que inicia el permiso"})
    
    */
    
    private $fecha_inicio;
    
    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha finalizacion del permiso"})
    
    */
    
    private $fecha_final;




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
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return DocentePermisoTiempo
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
     * @return DocentePermisoTiempo
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
     * Set idDocenteServicio
     *
     * @param \AppBundle\Entity\DocenteServicio $idDocenteServicio
     * @return DocentePermisoTiempo
     */
    public function setIdDocenteServicio(\AppBundle\Entity\DocenteServicio $idDocenteServicio = null)
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
}
