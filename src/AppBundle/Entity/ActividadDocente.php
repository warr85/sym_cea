<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActividadDocente
 *
 * @ORM\Table(name="actividad_docente", uniqueConstraints={@ORM\UniqueConstraint(name="uq_actividad_docente", columns={"nombre"})}, indexes={@ORM\Index(name="idx_actividad_docente_estatus", columns={"id_estatus"})})
 * @ORM\Entity
 */
class ActividadDocente
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable=false, options={"comment" = "Nombre de la actividad_docente"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador de la actividad_docente"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="escala_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

     /**
     * @var \AppBundle\Entity\Estatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEstatus;



    

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return ActividadDocente
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
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return ActividadDocente
     */
    public function setIdEstatus(\AppBundle\Entity\Estatus $idEstatus)
    {
        $this->idEstatus = $idEstatus;

        return $this;
    }

    /**
     * Get idEstatus
     *
     * @return \AppBundle\Entity\Estatus 
     */
    public function getIdEstatus()
    {
        return $this->idEstatus;
    }
    
    
    /**
     * Get toString
     *
     * @return string
     */
    public function __toString() {
        return $this->getNombre();
    }
}
