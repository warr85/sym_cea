<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionSeccionEspecifico
 *
 * @ORM\Table(name="planificacion_seccion_especifico")
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
     * @ORM\ManyToOne(targetEntity="PlanificacionSeccion", inversedBy="objetivoEspecifico")
     * @ORM\JoinColumn(name="planificacion_seccion_id", referencedColumnName="id", nullable=FALSE)
     */
    private $planificacionSeccionId;
    
  
    

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
     * Set planificacionSeccionId
     *
     * @param \AppBundle\Entity\PlanificacionSeccion $planificacionSeccionId
     * @return PlanificacionSeccionEspecifico
     */
    public function setPlanificacionSeccionId(\AppBundle\Entity\PlanificacionSeccion $planificacionSeccionId)
    {
        $this->planificacionSeccionId = $planificacionSeccionId;

        return $this;
    }

    /**
     * Get planificacionSeccionId
     *
     * @return \AppBundle\Entity\PlanificacionSeccion 
     */
    public function getPlanificacionSeccionId()
    {
        return $this->planificacionSeccionId;
    }
    
    
}
