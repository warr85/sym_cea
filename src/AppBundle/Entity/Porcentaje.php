<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Porcentaje
 *
 * @ORM\Table(name="porcentaje", uniqueConstraints={@ORM\UniqueConstraint(name="uq_nombre_porcentaje", columns={"nombre"})})
 * @ORM\Entity
 */
class Porcentaje
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable=false, options={"comment" = "registro de todos y cada uno de los porcentajes"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador de los porcentajes"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="porcentaje_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Porcentaje
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
     * @return string
     */
    public function __toString() 
    {
        return $this->getNombre();
    }
}