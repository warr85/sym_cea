<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seccion
 *
 * @ORM\Table(name="seccion", uniqueConstraints={@ORM\UniqueConstraint(name="uq_seccion", columns={"nombre"})})
 * @ORM\Entity
 */
class Seccion
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=20, nullable=false, options={"comment" = "nombre de la seccion"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de las seccion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="seccion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Seccion
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