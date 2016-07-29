<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscripcionCalificacion
 *
 * @ORM\Table(name="inscripcion_calificacion", uniqueConstraints={@ORM\UniqueConstraint(name="i_registro_nota", columns={"id_inscripcion", "id_calificacion"})}, indexes={@ORM\Index(name="fki_id_inscripcion", columns={"id_inscripcion"}), @ORM\Index(name="fki_id_calificacion", columns={"id_calificacion"}), @ORM\Index(name="fki_id_estatus_nota", columns={"id_estatus_nota"})})
 * @ORM\Entity
 */
class InscripcionCalificacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"= "identificador del registro de la nota"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="registro_nota_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Inscripcion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Inscripcion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_inscripcion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idInscripcion;

    /**
     * @var \AppBundle\Entity\Calificacion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calificacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_calificacion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idCalificacion;
    
    
    /**
     * @var \AppBundle\Entity\EstatusNota
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EstatusNota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus_nota", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEstatusNota;



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
     * Set idInscripcion
     *
     * @param \AppBundle\Entity\Inscripcion $idInscripcion
     * @return InscripcionCalificacion
     */
    public function setIdInscripcion(\AppBundle\Entity\Inscripcion $idInscripcion = null)
    {
        $this->idInscripcion = $idInscripcion;

        return $this;
    }

    /**
     * Get idInscripcion
     *
     * @return \AppBundle\Entity\Inscripcion 
     */
    public function getIdInscripcion()
    {
        return $this->idInscripcion;
    }

    /**
     * Set idCalificacion
     *
     * @param \AppBundle\Entity\Calificacion $idCalificacion
     * @return InscripcionCalificacion
     */
    public function setIdCalificacion(\AppBundle\Entity\Calificacion $idCalificacion = null)
    {
        $this->idCalificacion = $idCalificacion;

        return $this;
    }

    /**
     * Get idCalificacion
     *
     * @return \AppBundle\Entity\Calificacion 
     */
    public function getIdCalificacion()
    {
        return $this->idCalificacion;
    }

    /**
     * Set idEstatusNota
     *
     * @param \AppBundle\Entity\EstatusNota $idEstatusNota
     * @return InscripcionCalificacion
     */
    public function setIdEstatusNota(\AppBundle\Entity\EstatusNota $idEstatusNota)
    {
        $this->idEstatusNota = $idEstatusNota;

        return $this;
    }

    /**
     * Get idEstatusNota
     *
     * @return \AppBundle\Entity\EstatusNota 
     */
    public function getIdEstatusNota()
    {
        return $this->idEstatusNota;
    }
}
