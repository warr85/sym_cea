<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionSeccionEspecifico
 *
 * @ORM\Table(name="planificacion_seccion_especifico", 
 *      uniqueConstraints=
 *          {@ORM\UniqueConstraint(name="uq_planificacion_seccion_especifico", 
 *              columns={"id_planificacion_seccion"})
 *          }, 
 *          indexes={ 
 *              @ORM\Index(name="fki_id_planificacion_especifico", 
 *                  columns={"id_planificacion_seccion"})
 *          }
 *  )
 * @ORM\Entity
 */
class PlanificacionSeccionEspecifico
{
    /**
     * @var text
     *
     * @ORM\Column(name="objetivo_especifico", type="text", nullable=false, options={"comment" = "Objetivo Especifico de un tema"})
     */
    private $objetivoEspecifico;
    
    
        
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del municipio"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="municipio_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    
    /**
     * @var \AppBundle\Entity\PlanificacionSeccion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlanificacionSeccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_planificacion_seccion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPlanificacionSeccion;

    /**
     * @ORM\ManyToOne(targetEntity="PlanificacionSeccion", inversedBy="objetivoEspecifico")
     * @ORM\JoinColumn(name="id_planificacion_especifico", referencedColumnName="id")
     */
    private $idPlanificacionEspecifico;
    
  
    /**
     * Set objetivoEspecifico
     *
     * @param string $objetivoEspecifico
     * @return PlanificacionSeccionEspecifico
     */
    public function setObjetivoEspecifico($objetivoEspecifico)
    {
        $this->objetivoEspecifico = $objetivoEspecifico;

        return $this;
    }

    /**
     * Get objetivoEspecifico
     *
     * @return string 
     */
    public function getObjetivoEspecifico()
    {
        return $this->objetivoEspecifico;
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
     * Set idPlanificacionSeccion
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $idPlanificacionSeccion
     * @return PlanificacionSeccionEspecifico
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
     * Set idPlanificacionEspecifico
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $idPlanificacionEspecifico
     * @return PlanificacionSeccionEspecifico
     */
    public function setIdPlanificacionEspecifico(\AppBundle\Entity\PlanificacionSeccion $idPlanificacionEspecifico = null)
    {
        $this->idPlanificacionEspecifico = $idPlanificacionEspecifico;

        return $this;
    }

    /**
     * Get idPlanificacionEspecifico
     *
     * @return \AppBundle\Entity\PlanificacionSeccion 
     */
    public function getIdPlanificacionEspecifico()
    {
        return $this->idPlanificacionEspecifico;
    }
}
