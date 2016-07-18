<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MallaCurricularInstitucion
 *
 * @ORM\Table(name="malla_curricular_institucion", uniqueConstraints={@ORM\UniqueConstraint(name="i_malla_curricular_institucion", columns={"id_institucion", "id_malla_curricular"})}, indexes={@ORM\Index(name="fki_estatus_malla_curricular_institucion", columns={"id_estatus"}), @ORM\Index(name="fki_malla_curricular_malla_curricular_institucion", columns={"id_malla_curricular"}), @ORM\Index(name="fki_institucion_malla_curricular_institucion", columns={"id_institucion"})})
 * @ORM\Entity
 */
class MallaCurricularInstitucion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la malla curricular institucion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="malla_curricular_institucion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \AppBundle\Entity\Institucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Institucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idInstitucion;

    /**
     * @var \AppBundle\Entity\Estatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEstatus;



    

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
     * Set idMallaCurricular
     *
     * @param \AppBundle\Entity\MallaCurricular $idMallaCurricular
     * @return MallaCurricularInstitucion
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

    /**
     * Set idInstitucion
     *
     * @param \AppBundle\Entity\Institucion $idInstitucion
     * @return MallaCurricularInstitucion
     */
    public function setIdInstitucion(\AppBundle\Entity\Institucion $idInstitucion)
    {
        $this->idInstitucion = $idInstitucion;

        return $this;
    }

    /**
     * Get idInstitucion
     *
     * @return \AppBundle\Entity\Institucion 
     */
    public function getIdInstitucion()
    {
        return $this->idInstitucion;
    }

    /**
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return MallaCurricularInstitucion
     */
    public function setIdEstatus(\AppBundle\Entity\Estatus $idEstatus)
    {
        $this->idEstatus = $idEstatus;

        return $this;
    }

    /**
     * Get idEstatus
     *
     * @return \AppBundle\Entity\Estatus 
     */
    public function getIdEstatus()
    {
        return $this->idEstatus;
    }
}
