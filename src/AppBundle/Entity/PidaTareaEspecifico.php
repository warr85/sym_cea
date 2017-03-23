<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PidaTareaEspecifico
 *
 * @ORM\Table(name="pida_tarea_especifico")
 * @ORM\Entity
 */
class PidaTareaEspecifico
{
    /**
     * @var text
     *
     * @ORM\Column(name="pida_tarea_especifico", type="text", nullable=false, options={"comment" = "Tarea especifia ejecuta por el docenta bajo una labor y enmarcada en el plan de la patria"})
     */
    private $pidaTareaEspecifico;
    
    
        
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AdscripcionPida", inversedBy="pidaTareaEspecifico")
     * @ORM\JoinColumn(name="adscripcion_pida_id", referencedColumnName="id", nullable=FALSE)
     */
    private $adscripcionPidaId;

    /**
     * @var \AppBundle\Entity\PidaPlazo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PidaPlazo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pida_plazo", referencedColumnName="id", nullable=true)
     * })
     */
    protected $idPidaPlazo;


    /**
     * @var \AppBundle\Entity\PidaEstatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PidaEstatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pida_estatus", referencedColumnName="id", nullable=true)
     * })
     */
    protected $idPidaEstatus;
    
  


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
     * Set adscripcionPidaId
     *
     * @param \AppBundle\Entity\AdscripcionPida $adscripcionPidaId
     * @return PidaTareaEspecifico
     */
    public function setAdscripcionPidaId(\AppBundle\Entity\AdscripcionPida $adscripcionPidaId)
    {
        $this->adscripcionPidaId = $adscripcionPidaId;

        return $this;
    }

    /**
     * Get adscripcionPidaId
     *
     * @return \AppBundle\Entity\AdscripcionPida 
     */
    public function getAdscripcionPidaId()
    {
        return $this->adscripcionPidaId;
    }

    /**
     * Set pidaTareaEspecifico
     *
     * @param string $pidaTareaEspecifico
     * @return PidaTareaEspecifico
     */
    public function setPidaTareaEspecifico($pidaTareaEspecifico)
    {
        $this->pidaTareaEspecifico = $pidaTareaEspecifico;

        return $this;
    }

    /**
     * Get pidaTareaEspecifico
     *
     * @return string 
     */
    public function getPidaTareaEspecifico()
    {
        return $this->pidaTareaEspecifico;
    }

    /**
     * Set idPidaPlazo
     *
     * @param \AppBundle\Entity\PidaPlazo $idPidaPlazo
     * @return PidaTareaEspecifico
     */
    public function setIdPidaPlazo(\AppBundle\Entity\PidaPlazo $idPidaPlazo = null)
    {
        $this->idPidaPlazo = $idPidaPlazo;

        return $this;
    }

    /**
     * Get idPidaPlazo
     *
     * @return \AppBundle\Entity\PidaPlazo 
     */
    public function getIdPidaPlazo()
    {
        return $this->idPidaPlazo;
    }

    /**
     * Set idPidaEstatus
     *
     * @param \AppBundle\Entity\PidaEstatus $idPidaEstatus
     * @return PidaTareaEspecifico
     */
    public function setIdPidaEstatus(\AppBundle\Entity\PidaEstatus $idPidaEstatus = null)
    {
        $this->idPidaEstatus = $idPidaEstatus;

        return $this;
    }

    /**
     * Get idPidaEstatus
     *
     * @return \AppBundle\Entity\PidaEstatus 
     */
    public function getIdPidaEstatus()
    {
        return $this->idPidaEstatus;
    }
    public function __toString()
    {
        return $this->getPidaTareaEspecifico();
    }
}
