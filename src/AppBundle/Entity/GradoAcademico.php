<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GradoAcademico
 *
 * @ORM\Table(name="grado_academico", uniqueConstraints={@ORM\UniqueConstraint(name="uq_grado_academico", columns={"nombre", "abreviacion"})})
 * @ORM\Entity
 */
class GradoAcademico
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false, options={"comment" = "Nombre del grado academico"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviacion", type="string", length=5, nullable=false, options={"comment" = "Siglas del grado academico Ejm. Lic., TSU"})
     */
    private $abreviacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del grado_academico"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="grado_academico_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return GradoAcademico
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
     * Set abreviacion
     *
     * @param string $abreviacion
     * @return GradoAcademico
     */
    public function setAbreviacion($abreviacion)
    {
        $this->abreviacion = $abreviacion;

        return $this;
    }

    /**
     * Get abreviacion
     *
     * @return string 
     */
    public function getAbreviacion()
    {
        return $this->abreviacion;
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
