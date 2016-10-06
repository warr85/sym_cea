<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionCalificacion
 *
 * @ORM\Table(name="planificacion_calificacion", uniqueConstraints={@ORM\UniqueConstraint(name="i_registro_nota_planificacion", columns={"id_inscripcion", "id_calificacion", "id_planificacion_seccion"})}, indexes={@ORM\Index(name="fki_id_inscripcion_planificacion", columns={"id_inscripcion"}), @ORM\Index(name="fki_id_calificacion_planificacion", columns={"id_calificacion"}), @ORM\Index(name="fki_id_estatus_nota_planificacion", columns={"id_estatus_nota"}), @ORM\Index(name="fki_id_planificacion_seccion", columns={"id_planificacion_seccion"})})
 * @ORM\Entity
 */
class PlanificacionCalificacion
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
     * @var \AppBundle\Entity\PlanificacionSeccion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlanificacionSeccion", inversedBy="hasCalificacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_planificacion_seccion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPlanificacionSeccion;

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
     * Set idPlanificacionSeccion
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $idPlanificacionSeccion
     * @return PlanificacionCalificacion
     */
    public function setIdPlanificacionSeccion(\AppBundle\Entity\PlanificacionSeccion $idPlanificacionSeccion)
    {
        $this->idPlanificacionSeccion = $idPlanificacionSeccion;

        return $this;
    }

    /**
     * Get idPlanificacionSeccion
     *
     * @return \AppBundle\Entity\PlanificacionSeccion 
     */
    public function getIdPlanificacionSeccion()
    {
        return $this->idPlanificacionSeccion;
    }

    /**
     * Set idInscripcion
     *
     * @param \AppBundle\Entity\Inscripcion $idInscripcion
     * @return PlanificacionCalificacion
     */
    public function setIdInscripcion(\AppBundle\Entity\Inscripcion $idInscripcion)
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
     * @return PlanificacionCalificacion
     */
    public function setIdCalificacion(\AppBundle\Entity\Calificacion $idCalificacion)
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
     * @return PlanificacionCalificacion
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
