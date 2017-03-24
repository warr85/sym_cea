<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * PidaCaducidad
 *
 * @ORM\Table(name="pida_caducidad", uniqueConstraints={@ORM\UniqueConstraint(name="docete_servicio", columns={"id_docente_servicio"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class PidaCaducidad
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
     * @var \AppBundle\Entity\DocenteServicio
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DocenteServicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_docente_servicio", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idDocenteServicio;
    
    


    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha donde comienza a correr el tiempo del pida"})
    
    */
    
    private $fechaInicio;
    
    
    /** @ORM\Column(type="datetime", nullable=false, options={"comment" = "Fecha donde termina el Pida"})
    
    */
    
    private $fechaFinal;


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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return PidaCaducidad
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     * @return PidaCaducidad
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set idDocenteServicio
     *
     * @param \AppBundle\Entity\DocenteServicio $idDocenteServicio
     * @return PidaCaducidad
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
}
