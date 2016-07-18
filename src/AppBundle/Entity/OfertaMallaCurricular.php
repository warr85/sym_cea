<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaMallaCurricular
 *
 * @ORM\Table(name="oferta_malla_curricular", uniqueConstraints={@ORM\UniqueConstraint(name="i_oferta_malla_curricular", columns={"id_malla_curricular_institucion", "id_periodo"})}, indexes={@ORM\Index(name="fki_id_malla_curricular_institucion_oferta_malla_curricular", columns={"id_malla_curricular_institucion"}), @ORM\Index(name="fki_periodo_oferta_malla_curricular", columns={"id_periodo"})})
 * @ORM\Entity
 */
class OfertaMallaCurricular
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="oferta_malla_curricular_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Periodo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Periodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_periodo", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPeriodo;

    /**
     * @var \AppBundle\Entity\MallaCurricularInstitucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MallaCurricularInstitucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_malla_curricular_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idMallaCurricularInstitucion;



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
     * Set idPeriodo
     *
     * @param \AppBundle\Entity\Periodo $idPeriodo
     * @return OfertaMallaCurricular
     */
    public function setIdPeriodo(\AppBundle\Entity\Periodo $idPeriodo)
    {
        $this->idPeriodo = $idPeriodo;

        return $this;
    }

    /**
     * Get idPeriodo
     *
     * @return \AppBundle\Entity\Periodo 
     */
    public function getIdPeriodo()
    {
        return $this->idPeriodo;
    }

    /**
     * Set idMallaCurricularInstitucion
     *
     * @param \AppBundle\Entity\MallaCurricularInstitucion $idMallaCurricularInstitucion
     * @return OfertaMallaCurricular
     */
    public function setIdMallaCurricularInstitucion(\AppBundle\Entity\MallaCurricularInstitucion $idMallaCurricularInstitucion)
    {
        $this->idMallaCurricularInstitucion = $idMallaCurricularInstitucion;

        return $this;
    }

    /**
     * Get idMallaCurricularInstitucion
     *
     * @return \AppBundle\Entity\MallaCurricularInstitucion 
     */
    public function getIdMallaCurricularInstitucion()
    {
        return $this->idMallaCurricularInstitucion;
    }
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        return $this->getIdMallaCurricularInstitucion()->getIdMallaCurricular()->getNombre();
    }
}
