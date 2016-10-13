<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanHistoricoNacionalEstrategico
 *
 * @ORM\Table(name="plan_historico_nacional_estrategico", uniqueConstraints={@ORM\UniqueConstraint(name="uq_estrategico", columns={"numero"})}, indexes={@ORM\Index(name="fki_id_nacional_estrategico", columns={"id_plan_historico_nacional"})})
 * @ORM\Entity
 */
class PlanHistoricoNacionalEstrategico
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=40, nullable=false, options={"comment" = "nombre de plan_historico_nacional_estrategico"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=false, options={"comment" = "codigo plan_historico_nacional_estrategico"})
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador de la plan_historico_nacional_estrategico"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="parroquia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\PlanHistoricoNacional
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlanHistoricoNacional")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_plan_historico_nacional", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPlanHistoricoNacional;
    

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return PlanHistoricoNacionalEstrategico
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
     * @return PlanHistoricoNacionalEstrategico
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
     * Set idPlanHistoricoNacional
     *
     * @param \AppBundle\Entity\PlanHistoricoNacional $idPlanHistoricoNacional
     * @return PlanHistoricoNacionalEstrategico
     */
    public function setIdPlanHistoricoNacional(\AppBundle\Entity\PlanHistoricoNacional $idPlanHistoricoNacional)
    {
        $this->idPlanHistoricoNacional = $idPlanHistoricoNacional;

        return $this;
    }

    /**
     * Get idPlanHistoricoNacional
     *
     * @return \AppBundle\Entity\PlanHistoricoNacional 
     */
    public function getIdPlanHistoricoNacional()
    {
        return $this->idPlanHistoricoNacional;
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
