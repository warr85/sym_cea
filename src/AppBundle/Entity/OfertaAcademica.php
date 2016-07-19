<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaAcademica
 *
 * @ORM\Table(name="oferta_academica", uniqueConstraints={@ORM\UniqueConstraint(name="i_oferta_academica", columns={"id_malla_curricular_uc", "id_seccion", "id_oferta_malla_curricular"})}, indexes={@ORM\Index(name="fki_oferta_malla_curricular_oferta_academica", columns={"id_oferta_malla_curricular"}), @ORM\Index(name="fki_seccion_oferta_academica", columns={"id_seccion"}), @ORM\Index(name="fki_turno_oferta_academica", columns={"id_turno"}), @ORM\Index(name="fki_rol_institucion_oferta_academica", columns={"id_rol_institucion"}), @ORM\Index(name="fki_malla_curricular_uc_oferta_academica", columns={"id_malla_curricular_uc"})})
 * @ORM\Entity
 */
class OfertaAcademica
{
    /**
     * @var string
     *
     * @ORM\Column(name="aula", type="string", length=10, nullable=true, options={"comment" = "Indica el aula donde se va a dictar la unidad curricular (EN OBSERVACION, ESTE VALOR PUEDE SER VARIABLE PARA UNA MISMA OFERTA)"})
     */
    private $aula;

    /**
     * @var string
     *
     * @ORM\Column(name="cupo", type="decimal", precision=2, scale=0, nullable=false, options={"comment" = "Indica el numero de cupos para esa oferta"})
     */
    private $cupo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la unidad cirrucular"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="oferta_academica_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\MallaCurricularUC
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MallaCurricularUc")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_malla_curricular_uc", referencedColumnName="id", nullable=false)
     * })
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Inscripcion", inversedBy="uc")
     */
    private $idMallaCurricularUc;

    /**
     * @var \AppBundle\Entity\Turno
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Turno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_turno", referencedColumnName="id", nullable=false)
     * })
     */
    private $idTurno;

    /**
     * @var \AppBundle\Entity\Seccion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Seccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_seccion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idSeccion;

    /**
     * @var \AppBundle\Entity\RolInstitucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RolInstitucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idRolInstitucion;

    /**
     * @var \AppBundle\Entity\OfertaMallaCurricular
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OfertaMallaCurricular")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_oferta_malla_curricular", referencedColumnName="id", nullable=false)
     * })
     */
    private $idOfertaMallaCurricular;
   

    /**
     * Set aula
     *
     * @param string $aula
     * @return OfertaAcademica
     */
    public function setAula($aula)
    {
        $this->aula = $aula;

        return $this;
    }

    /**
     * Get aula
     *
     * @return string 
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * Set cupo
     *
     * @param string $cupo
     * @return OfertaAcademica
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return string 
     */
    public function getCupo()
    {
        return $this->cupo;
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
     * Set idMallaCurricularUc
     *
     * @param \AppBundle\Entity\MallaCurricularUC $idMallaCurricularUc
     * @return OfertaAcademica
     */
    public function setIdMallaCurricularUc(\AppBundle\Entity\MallaCurricularUC $idMallaCurricularUc)
    {
        $this->idMallaCurricularUc = $idMallaCurricularUc;

        return $this;
    }

    /**
     * Get idMallaCurricularUc
     *
     * @return \AppBundle\Entity\MallaCurricularUC 
     */
    public function getIdMallaCurricularUc()
    {
        return $this->idMallaCurricularUc;
    }

    /**
     * Set idTurno
     *
     * @param \AppBundle\Entity\Turno $idTurno
     * @return OfertaAcademica
     */
    public function setIdTurno(\AppBundle\Entity\Turno $idTurno)
    {
        $this->idTurno = $idTurno;

        return $this;
    }

    /**
     * Get idTurno
     *
     * @return \AppBundle\Entity\Turno 
     */
    public function getIdTurno()
    {
        return $this->idTurno;
    }

    /**
     * Set idSeccion
     *
     * @param \AppBundle\Entity\Seccion $idSeccion
     * @return OfertaAcademica
     */
    public function setIdSeccion(\AppBundle\Entity\Seccion $idSeccion)
    {
        $this->idSeccion = $idSeccion;

        return $this;
    }

    /**
     * Get idSeccion
     *
     * @return \AppBundle\Entity\Seccion 
     */
    public function getIdSeccion()
    {
        return $this->idSeccion;
    }

    /**
     * Set idRolInstitucion
     *
     * @param \AppBundle\Entity\RolInstitucion $idRolInstitucion
     * @return OfertaAcademica
     */
    public function setIdRolInstitucion(\AppBundle\Entity\RolInstitucion $idRolInstitucion)
    {
        $this->idRolInstitucion = $idRolInstitucion;

        return $this;
    }

    /**
     * Get idRolInstitucion
     *
     * @return \AppBundle\Entity\RolInstitucion 
     */
    public function getIdRolInstitucion()
    {
        return $this->idRolInstitucion;
    }

    /**
     * Set idOfertaMallaCurricular
     *
     * @param \AppBundle\Entity\OfertaMallaCurricular $idOfertaMallaCurricular
     * @return OfertaAcademica
     */
    public function setIdOfertaMallaCurricular(\AppBundle\Entity\OfertaMallaCurricular $idOfertaMallaCurricular)
    {
        $this->idOfertaMallaCurricular = $idOfertaMallaCurricular;

        return $this;
    }

    /**
     * Get idOfertaMallaCurricular
     *
     * @return \AppBundle\Entity\OfertaMallaCurricular 
     */
    public function getIdOfertaMallaCurricular()
    {
        return $this->idOfertaMallaCurricular;
    }
    
    public function __toString() {
        return $this->getIdMallaCurricularUc()->getIdUnidadCurricularVolumen()->getIdUnidadCurricular()->getNombre();
    }

    /**
     * Set inscripcion
     *
     * @param \AppBundle\Entity\MallaCurricularUc $inscripcion
     * @return OfertaAcademica
     */
    public function setInscripcion(\AppBundle\Entity\MallaCurricularUc $inscripcion)
    {
        $this->inscripcion = $inscripcion;

        return $this;
    }

    /**
     * Get inscripcion
     *
     * @return \AppBundle\Entity\MallaCurricularUc 
     */
    public function getInscripcion()
    {
        return $this->inscripcion;
    }
}
