<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecursosPlanificacion
 *
 * @ORM\Table(name="recursos_planficacion", uniqueConstraints={@ORM\UniqueConstraint(name="uq_recursos", columns={"nombre"})})
 * @ORM\Entity
 */
class RecursosPlanificacion
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false, options={"comment" = "Nombre del municipio"})
     */
    private $nombre;
    

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PlanificacionSeccionEstrategia", mappedBy="recursos")
     */
    protected $estrategia;

    
   
    
    
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estrategia = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return RecursosPlanificacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
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
     * Add estrategia
     *
     * @param \AppBundle\Entity\PlanificacionSeccionEstrategia $estrategia
     * @return RecursosPlanificacion
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
     * @return string
     */
    public function __toString() {
        return $this->getNombre();
    }
}
