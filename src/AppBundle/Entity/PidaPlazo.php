<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 08:12 AM
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PidaPlazo
 *
 * @ORM\Table(name="pida_plazo", uniqueConstraints={@ORM\UniqueConstraint(name="uq_pida_plazo", columns={"nombre"})})
 * @ORM\Entity
 */
class PidaPlazo
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=20, nullable=false, options={"comment" = "Nombre del estatus"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50, nullable=false, options={"comment" = "Descripcion o significado del estatus"})
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del estatus"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="estatus_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Estatus
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Estatus
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
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
    
    public function __toString() {
        return $this->getNombre();
    }
}