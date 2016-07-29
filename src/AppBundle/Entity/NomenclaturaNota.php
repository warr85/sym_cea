<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NomenclaturaNota
 *
 * @ORM\Table(name="nomenclatura_nota", uniqueConstraints={@ORM\UniqueConstraint(name="uq_descripcion_nomenclatura_nota", columns={"descripcion"}), @ORM\UniqueConstraint(name="uq_nombre_nomenclatura_nota", columns={"nombre"})})
 * @ORM\Entity
 */
class NomenclaturaNota
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable=false, options={"comment" = "Nombre de la nomenclatura"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=false, options={"comment" = "Descripcion de la nomenclatura"})
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la nomenclatura"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="nomenclatura_nota_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return NomenclaturaNota
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
     * @return NomenclaturaNota
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
}
