<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanHistoricoNacional
 *
 * @ORM\Table(name="plan_historico_nacional", uniqueConstraints={@ORM\UniqueConstraint(name="uq_nacional", columns={"numero"})}, indexes={@ORM\Index(name="fki_historico_nacional", columns={"id_plan_objetivo_historico"})})
 * @ORM\Entity
 */
class PlanHistoricoNacional
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false, options={"comment" = "Nombre del plan_historico_nacional"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=false, options={"comment" = "numero del objetivo nacional"})
     */
    private $numero;
    
   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del plan_historico_nacional"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="municipio_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\PlanObjetivoHistorico
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlanObjetivoHistorico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_plan_objetivo_historico", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPlanObjetivoHistorico;

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return PlanHistoricoNacional
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
     * Set numero
     *
     * @param integer $numero
     * @return PlanHistoricoNacional
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
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
     * Set idPlanObjetivoHistorico
     *
     * @param \AppBundle\Entity\PlanObjetivoHistorico $idPlanObjetivoHistorico
     * @return PlanHistoricoNacional
     */
    public function setIdPlanObjetivoHistorico(\AppBundle\Entity\PlanObjetivoHistorico $idPlanObjetivoHistorico)
    {
        $this->idPlanObjetivoHistorico = $idPlanObjetivoHistorico;

        return $this;
    }

    /**
     * Get idPlanObjetivoHistorico
     *
     * @return \AppBundle\Entity\PlanObjetivoHistorico 
     */
    public function getIdPlanObjetivoHistorico()
    {
        return $this->idPlanObjetivoHistorico;
    }
    
    
    /**
     * Get nombre
     *
     * @return string
     */
    public function __toString() {
        return $this->getNombre();
    }
    
    
}
