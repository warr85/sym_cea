<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Periodo
 *
 * @ORM\Table(name="periodo")
 * @ORM\Entity
 */
class Periodo
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=8, nullable=false, options={"comment" = "nombre periodo"})
     */
    private $nombre;

    /**
     * @var \AppBundle\Entity\Estatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEstatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del periodo lectivo"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="periodo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Periodo
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
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return Periodo
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
    
    public function __toString() {
        return $this->getNombre();
    }
}
