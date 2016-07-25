<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionSeccionContenido
 *
 * @ORM\Table(name="planificacion_seccion_contenido", 
 *      uniqueConstraints=
 *          {@ORM\UniqueConstraint(name="uq_planificacion_seccion_contenido", 
 *              columns={"id_planificacion_seccion"})
 *          }, 
 *          indexes={ 
 *              @ORM\Index(name="fki_id_planificacion_seccion", 
 *                  columns={"id_planificacion_seccion"})
 *          }
 *  )
 * @ORM\Entity
 */
class PlanificacionSeccionContenido
{
    /**
     * @var text
     *
     * @ORM\Column(name="conceptual", type="text", nullable=false, options={"comment" = "Contenido Conceptual"})
     */
    private $conceptual;
    
    
    /**
     * @var text
     *
     * @ORM\Column(name="procedimental", type="text", nullable=false, options={"comment" = "Contenido Procedimental"})
     */
    private $procedimental;
    
    
    
    /**
     * @var text
     *
     * @ORM\Column(name="actitudinal", type="text", nullable=false, options={"comment" = "Contenido actitudinal"})
     */
    private $actitudinal;

    
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
     * Set conceptual
     *
     * @param string $conceptual
     * @return PlanificacionSeccionContenido
     */
    public function setConceptual($conceptual)
    {
        $this->conceptual = $conceptual;

        return $this;
    }

    /**
     * Get conceptual
     *
     * @return string 
     */
    public function getConceptual()
    {
        return $this->conceptual;
    }

    /**
     * Set procedimental
     *
     * @param string $procedimental
     * @return PlanificacionSeccionContenido
     */
    public function setProcedimental($procedimental)
    {
        $this->procedimental = $procedimental;

        return $this;
    }

    /**
     * Get procedimental
     *
     * @return string 
     */
    public function getProcedimental()
    {
        return $this->procedimental;
    }

    /**
     * Set actitudinal
     *
     * @param string $actitudinal
     * @return PlanificacionSeccionContenido
     */
    public function setActitudinal($actitudinal)
    {
        $this->actitudinal = $actitudinal;

        return $this;
    }

    /**
     * Get actitudinal
     *
     * @return string 
     */
    public function getActitudinal()
    {
        return $this->actitudinal;
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
     * @return PlanificacionSeccionContenido
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
}
