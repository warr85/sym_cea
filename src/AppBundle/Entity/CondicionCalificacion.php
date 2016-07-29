<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CondicionCalificacion
 *
 * @ORM\Table(name="condicion_calificacion", uniqueConstraints={@ORM\UniqueConstraint(name="uq_nombre_condicion_calificacion", columns={"nombre"})})
 * @ORM\Entity
 */
class CondicionCalificacion
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false, options={"comment" = "Nombre de la condicion de la calificacion"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="siglas", type="string", nullable=true, options={"comment" = "Siglas de condicion de la calificacion"})
     */
    private $siglas;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer",  nullable=true, options={"comment" = "Identificador de la condicion de la calificacion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="condicion_calificacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return CondicionCalificacion
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
     * Set siglas
     *
     * @param string $siglas
     * @return CondicionCalificacion
     */
    public function setSiglas($siglas)
    {
        $this->siglas = $siglas;

        return $this;
    }

    /**
     * Get siglas
     *
     * @return string 
     */
    public function getSiglas()
    {
        return $this->siglas;
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