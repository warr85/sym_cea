<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tramo
 *
 * @ORM\Table(name="tramo", uniqueConstraints={@ORM\UniqueConstraint(name="uq_tramo_nombre", columns={"nombre"})})
 * @ORM\Entity
 */
class Tramo
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=10, nullable=false, options={"comment" = "nombre del tramo"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del tramo"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="tramo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Tramo
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
     * 
     * @return string
     */
    
    public function __toString() {
        return $this->getNombre();
    }
}
