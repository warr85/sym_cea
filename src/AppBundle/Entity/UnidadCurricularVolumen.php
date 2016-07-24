<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnidadCurricularVolumen
 *
 * @ORM\Table(name="unidad_curricular_volumen", uniqueConstraints={@ORM\UniqueConstraint(name="i_unidad_curricular_volumen", columns={"id_unidad_curricular", "id_volumen"})}, indexes={@ORM\Index(name="fki_volumen_unidad_curricular_volumen", columns={"id_volumen"}), @ORM\Index(name="IDX_A893E1FC3885FA9C", columns={"id_unidad_curricular"})})
 * @ORM\Entity
 */
class UnidadCurricularVolumen
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la unidad curricular en un volumen especifico"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="unidad_curricular_volumen_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Volumen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Volumen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_volumen", referencedColumnName="id", nullable=false)
     * })
     */
    private $idVolumen;

    /**
     * @var \AppBundle\Entity\UnidadCurricular
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnidadCurricular")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_unidad_curricular", referencedColumnName="id", nullable=false)
     * })
     */
    private $idUnidadCurricular;



   

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
     * Set idVolumen
     *
     * @param \AppBundle\Entity\Volumen $idVolumen
     * @return UnidadCurricularVolumen
     */
    public function setIdVolumen(\AppBundle\Entity\Volumen $idVolumen)
    {
        $this->idVolumen = $idVolumen;

        return $this;
    }

    /**
     * Get idVolumen
     *
     * @return \AppBundle\Entity\Volumen 
     */
    public function getIdVolumen()
    {
        return $this->idVolumen;
    }

    /**
     * Set idUnidadCurricular
     *
     * @param \AppBundle\Entity\UnidadCurricular $idUnidadCurricular
     * @return UnidadCurricularVolumen
     */
    public function setIdUnidadCurricular(\AppBundle\Entity\UnidadCurricular $idUnidadCurricular)
    {
        $this->idUnidadCurricular = $idUnidadCurricular;

        return $this;
    }

    /**
     * Get idUnidadCurricular
     *
     * @return \AppBundle\Entity\UnidadCurricular 
     */
    public function getIdUnidadCurricular()
    {
        return $this->idUnidadCurricular;
    }
    
    public function __toString() {
        return $this->getIdUnidadCurricular();
    }
}
