<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MallaCurricularUc
 *
 * @ORM\Table(name="malla_curricular_uc", uniqueConstraints={@ORM\UniqueConstraint(name="i_malla_curricular", columns={"id_malla_curricular", "id_unidad_curricular_volumen"})}, indexes={@ORM\Index(name="fki_malla_curricular_malla_curricular_uc", columns={"id_malla_curricular"}), @ORM\Index(name="fki_trayecto_tramo_modalidad_malla_curricular_tipo_uc", columns={"id_trayecto_tramo_modalidad_tipo_uc"}), @ORM\Index(name="fki_unidad_curricular_volumen_malla_curricular", columns={"id_unidad_curricular_volumen"})})
 * @ORM\Entity
 */
class MallaCurricularUc
{
    /**
     * @var string
     *
     * @ORM\Column(name="num_tramos", type="decimal", precision=2, scale=0, nullable=false, options={"comment" = "Numero de tramos de la unidad curricular"})
     */
    private $numTramos;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del registro"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="malla_curricular_uc_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\UnidadCurricularVolumen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnidadCurricularVolumen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_unidad_curricular_volumen", referencedColumnName="id", nullable=false)
     * })
     */
    private $idUnidadCurricularVolumen;

    /**
     * @var \AppBundle\Entity\TrayectoTramoModalidadTipo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TrayectoTramoModalidadTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_trayecto_tramo_modalidad_tipo_uc", referencedColumnName="id", nullable=false)
     * })
     */
    private $idTrayectoTramoModalidadTipoUc;

    /**
     * @var \AppBundle\Entity\MallaCurricular
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MallaCurricular")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_malla_curricular", referencedColumnName="id", nullable=false)
     * })
     */
    private $idMallaCurricular;


    /**
     * Set numTramos
     *
     * @param string $numTramos
     * @return MallaCurricularUc
     */
    public function setNumTramos($numTramos)
    {
        $this->numTramos = $numTramos;

        return $this;
    }

    /**
     * Get numTramos
     *
     * @return string 
     */
    public function getNumTramos()
    {
        return $this->numTramos;
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
     * Set idUnidadCurricularVolumen
     *
     * @param \AppBundle\Entity\UnidadCurricularVolumen $idUnidadCurricularVolumen
     * @return MallaCurricularUc
     */
    public function setIdUnidadCurricularVolumen(\AppBundle\Entity\UnidadCurricularVolumen $idUnidadCurricularVolumen)
    {
        $this->idUnidadCurricularVolumen = $idUnidadCurricularVolumen;

        return $this;
    }

    /**
     * Get idUnidadCurricularVolumen
     *
     * @return \AppBundle\Entity\UnidadCurricularVolumen 
     */
    public function getIdUnidadCurricularVolumen()
    {
        return $this->idUnidadCurricularVolumen;
    }

    /**
     * Set idTrayectoTramoModalidadTipoUc
     *
     * @param \AppBundle\Entity\TrayectoTramoModalidadTipo $idTrayectoTramoModalidadTipoUc
     * @return MallaCurricularUc
     */
    public function setIdTrayectoTramoModalidadTipoUc(\AppBundle\Entity\TrayectoTramoModalidadTipo $idTrayectoTramoModalidadTipoUc)
    {
        $this->idTrayectoTramoModalidadTipoUc = $idTrayectoTramoModalidadTipoUc;

        return $this;
    }

    /**
     * Get idTrayectoTramoModalidadTipoUc
     *
     * @return \AppBundle\Entity\TrayectoTramoModalidadTipo 
     */
    public function getIdTrayectoTramoModalidadTipoUc()
    {
        return $this->idTrayectoTramoModalidadTipoUc;
    }

    /**
     * Set idMallaCurricular
     *
     * @param \AppBundle\Entity\MallaCurricular $idMallaCurricular
     * @return MallaCurricularUc
     */
    public function setIdMallaCurricular(\AppBundle\Entity\MallaCurricular $idMallaCurricular)
    {
        $this->idMallaCurricular = $idMallaCurricular;

        return $this;
    }

    /**
     * Get idMallaCurricular
     *
     * @return \AppBundle\Entity\MallaCurricular 
     */
    public function getIdMallaCurricular()
    {
        return $this->idMallaCurricular;
    }
    
    
    public function __toString() 
    {
        return $this->getIdUnidadCurricularVolumen()->getIdUnidadCurricular()->getNombre();
    }
    
}
