<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaAcademica
 *
 * @ORM\Table(name="oferta_academica", 
 *      uniqueConstraints=
 *          {@ORM\UniqueConstraint(name="i_oferta_academica", 
 *              columns={"id_malla_curricular_uc", "id_oferta_malla_curricular"})
 *          }, 
 *          indexes={
 *              @ORM\Index(name="fki_oferta_malla_curricular_oferta_academica", 
 *                      columns={"id_oferta_malla_curricular"}),               
 *              @ORM\Index(name="fki_malla_curricular_uc_oferta_academica", 
 *                  columns={"id_malla_curricular_uc"})
 *          }
 *  )
 * @ORM\Entity
 */
class OfertaAcademica
{
    

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
     */
    private $idMallaCurricularUc;
    
    
    

    /**
     * @ORM\OneToMany(targetEntity="Seccion", mappedBy="ofertaAcademica")
     */
    private $seccion;

   

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
     * Constructor
     */
    public function __construct()
    {
        $this->seccion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \AppBundle\Entity\MallaCurricularUc $idMallaCurricularUc
     * @return OfertaAcademica
     */
    public function setIdMallaCurricularUc(\AppBundle\Entity\MallaCurricularUc $idMallaCurricularUc)
    {
        $this->idMallaCurricularUc = $idMallaCurricularUc;

        return $this;
    }

    /**
     * Get idMallaCurricularUc
     *
     * @return \AppBundle\Entity\MallaCurricularUc 
     */
    public function getIdMallaCurricularUc()
    {
        return $this->idMallaCurricularUc;
    }

    /**
     * Add seccion
     *
     * @param \AppBundle\Entity\Seccion $seccion
     * @return OfertaAcademica
     */
    public function addSeccion(\AppBundle\Entity\Seccion $seccion)
    {
        $this->seccion[] = $seccion;

        return $this;
    }

    /**
     * Remove seccion
     *
     * @param \AppBundle\Entity\Seccion $seccion
     */
    public function removeSeccion(\AppBundle\Entity\Seccion $seccion)
    {
        $this->seccion->removeElement($seccion);
    }

    /**
     * Get seccion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeccion()
    {
        return $this->seccion;
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
}
