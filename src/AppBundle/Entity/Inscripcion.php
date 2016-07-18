<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscripcion
 *
 * @ORM\Table(name="inscripcion", uniqueConstraints={@ORM\UniqueConstraint(name="i_inscripcion", columns={"id_oferta_academica", "id_estado_academico"})}, indexes={@ORM\Index(name="oferta_academica_inscripcion", columns={"id_oferta_academica"}), @ORM\Index(name="fki_estado_academico_inscripcion", columns={"id_estado_academico"}), @ORM\Index(name="fki_estatus_inscripcion", columns={"id_estatus"})})
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
     * @var \AppBundle\Entity\EstadoAcademico
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EstadoAcademico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado_academico", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEstadoAcademico;

    /**
     * @var \AppBundle\Entity\OfertaAcademica
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OfertaAcademica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_oferta_academica", referencedColumnName="id", nullable=false)
     * })
     */
    private $idOfertaAcademica;

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
    public function setIdEstadoAcademico(\AppBundle\Entity\EstadoAcademico $idEstadoAcademico)
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
     * Set idOfertaAcademica
     *
     * @param \AppBundle\Entity\OfertaAcademica $idOfertaAcademica
     * @return Inscripcion
     */
    public function setIdOfertaAcademica(\AppBundle\Entity\OfertaAcademica $idOfertaAcademica)
    {
        $this->idOfertaAcademica = $idOfertaAcademica;

        return $this;
    }

    /**
     * Get idOfertaAcademica
     *
     * @return \AppBundle\Entity\OfertaAcademica 
     */
    public function getIdOfertaAcademica()
    {
        return $this->idOfertaAcademica;
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
