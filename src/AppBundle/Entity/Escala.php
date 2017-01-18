<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Escala
 *
 * @ORM\Table(name="escala", uniqueConstraints={@ORM\UniqueConstraint(name="uq_escala", columns={"nombre"})}, indexes={@ORM\Index(name="IDX_C4F229CA50BDD1F3", columns={"id_estatus"})})
 * @ORM\Entity
 */
class Escala
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable=false, options={"comment" = "Nombre de la escala de calificacion"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador de la escala"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="escala_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Escala
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
     * @return Escala
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
     * @return string
     */
    public function __toString() {
        return $this->getNombre();
    }
}
