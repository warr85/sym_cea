<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionSeccionEstrategia
 *
 * @ORM\Table(name="planificacion_seccion_estrategia", 
 *      uniqueConstraints=
 *          {@ORM\UniqueConstraint(name="uq_planificacion_estrategia", 
 *              columns={"id_planificacion_seccion"})
 *          }, 
 *          indexes={ 
 *              @ORM\Index(name="fki_id_planificacion_estrategia", 
 *                  columns={"id_planificacion_seccion"})
 *          }
 *  )
 * @ORM\Entity
 */
class PlanificacionSeccionEstrategia
{
    
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del municipio"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="municipio_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var text
     *
     * @ORM\Column(name="tipo_estrategia", type="text", nullable=false, options={"comment" = "Tipos de estrategia a utilizar"})
     */
    private $tipoEstrategia;
    
    
    /**
     * @var text
     *
     * @ORM\Column(name="tipoRecurso", type="text", nullable=false, options={"comment" = "Recursos necesarios para el tema"})
     */
    private $tipoRecurso;
    
    /**
     * @ORM\ManyToOne(targetEntity="PlanificacionSeccion", inversedBy="estrategia")
     * @ORM\JoinColumn(name="id_planificacion_estrategia", referencedColumnName="id")
     */
    private $idPlanificacionEstrategia;

    

    

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
     * Set tipoEstrategia
     *
     * @param string $tipoEstrategia
     * @return PlanificacionSeccionEstrategia
     */
    public function setTipoEstrategia($tipoEstrategia)
    {
        $this->tipoEstrategia = $tipoEstrategia;

        return $this;
    }

    /**
     * Get tipoEstrategia
     *
     * @return string 
     */
    public function getTipoEstrategia()
    {
        return $this->tipoEstrategia;
    }

    /**
     * Set tipoRecurso
     *
     * @param string $tipoRecurso
     * @return PlanificacionSeccionEstrategia
     */
    public function setTipoRecurso($tipoRecurso)
    {
        $this->tipoRecurso = $tipoRecurso;

        return $this;
    }

    /**
     * Get tipoRecurso
     *
     * @return string 
     */
    public function getTipoRecurso()
    {
        return $this->tipoRecurso;
    }

    /**
     * Set idPlanificacionSeccion
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $idPlanificacionSeccion
     * @return PlanificacionSeccionEstrategia
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
     * Set idPlanificacionEstrategia
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $idPlanificacionEstrategia
     * @return PlanificacionSeccionEstrategia
     */
    public function setIdPlanificacionEstrategia(\AppBundle\Entity\PlanificacionSeccion $idPlanificacionEstrategia = null)
    {
        $this->idPlanificacionEstrategia = $idPlanificacionEstrategia;

        return $this;
    }

    /**
     * Get idPlanificacionEstrategia
     *
     * @return \AppBundle\Entity\PlanificacionSeccion 
     */
    public function getIdPlanificacionEstrategia()
    {
        return $this->idPlanificacionEstrategia;
    }
}
