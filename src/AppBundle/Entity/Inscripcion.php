<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscripcion
 *
 * @ORM\Table(name="inscripcion")
 * @ORM\Entity
 */
class Inscripcion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la inscripcion del estudiante"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="inscripcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EstadoAcademico", inversedBy="hasInscripcion")
     * @ORM\JoinColumn(name="estado_academico_id", referencedColumnName="id")
     * */
    private $idEstadoAcademico;

     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Seccion", inversedBy="hasInscripcion")
     * @ORM\JoinColumn(name="oferta_academica_id", referencedColumnName="id")
     * */
    private $idSeccion;
    
  
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idEstadoAcademico
     *
     * @param \AppBundle\Entity\EstadoAcademico $idEstadoAcademico
     * @return Inscripcion
     */
    public function setIdEstadoAcademico(\AppBundle\Entity\EstadoAcademico $idEstadoAcademico = null)
    {
        $this->idEstadoAcademico = $idEstadoAcademico;

        return $this;
    }

    /**
     * Get idEstadoAcademico
     *
     * @return \AppBundle\Entity\EstadoAcademico 
     */
    public function getIdEstadoAcademico()
    {
        return $this->idEstadoAcademico;
    }

    /**
     * Set idSeccion
     *
     * @param \AppBundle\Entity\Seccion $idSeccion
     * @return Inscripcion
     */
    public function setIdSeccion(\AppBundle\Entity\Seccion $idSeccion = null)
    {
        $this->idSeccion = $idSeccion;

        return $this;
    }

    /**
     * Get idSeccion
     *
     * @return \AppBundle\Entity\Seccion 
     */
    public function getIdSeccion()
    {
        return $this->idSeccion;
    }

    /**
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return Inscripcion
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
}
