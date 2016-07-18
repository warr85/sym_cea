<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modalidad
 *
 * @ORM\Table(name="modalidad", uniqueConstraints={@ORM\UniqueConstraint(name="uq_modalidad", columns={"nombre"})})
 * @ORM\Entity
 */
class Modalidad
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=20, nullable=false,  options={"comment" = "Nombre de la modalidad de estudio"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false,  options={"comment" = "Identificador de la modalidad"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="modalidad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Modalidad
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