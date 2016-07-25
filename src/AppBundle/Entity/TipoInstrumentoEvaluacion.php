<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoInstrumentoEvaluacion
 *
 * @ORM\Table(name="tipo_instrumento_evaluacion", uniqueConstraints={@ORM\UniqueConstraint(name="uq_tipo_instrumento_evaluacion", columns={"nombre"})})
 * @ORM\Entity
 */
class TipoInstrumentoEvaluacion
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false, options={"comment" = "nombre del estado"})
     */
    private $nombre;

    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del estado"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="estado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    

    /**
     * Get nombre
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nombre;
    }



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return TipoInstrumentoEvaluacion
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
}
