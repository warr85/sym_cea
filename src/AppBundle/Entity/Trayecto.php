<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trayecto
 *
 * @ORM\Table(name="trayecto", uniqueConstraints={@ORM\UniqueConstraint(name="uq_trayecto_nombre", columns={"nombre"})})
 * @ORM\Entity
 */
class Trayecto
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=4, nullable=false, options={"comment" = "nombre del trayecto"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del trayecto"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="trayecto_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Trayecto
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
