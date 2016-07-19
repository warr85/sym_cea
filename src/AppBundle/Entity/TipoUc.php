<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoUc
 *
 * @ORM\Table(name="tipo_uc", uniqueConstraints={@ORM\UniqueConstraint(name="uq_tipouc_nombre", columns={"nombre"})})
 * @ORM\Entity
 */
class TipoUc
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=10, nullable=false, options={"comment" = "nombre del tipo de unidad curricular (optativa, obligatoria, electiva)"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del tipo de unidad curricular"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="tipo_uc_id_seq", allocationSize=1, initialValue=1)
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
