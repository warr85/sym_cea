<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calificacion
 *
 * @ORM\Table(name="calificacion", uniqueConstraints={@ORM\UniqueConstraint(name="i_calificacion", columns={"id_nota", "id_condicion_calificacion", "id_porcentaje"})}, indexes={@ORM\Index(name="fki_id_porcentaje", columns={"id_porcentaje"}), @ORM\Index(name="fki_condicion_calificacion", columns={"id_condicion_calificacion"}), @ORM\Index(name="fki_id_nota", columns={"id_nota"})})
 * @ORM\Entity
 */
class Calificacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Este campo representa el identificador unico de la tabla calificacion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="calificacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Porcentaje
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Porcentaje")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_porcentaje", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPorcentaje;

    /**
     * @var \AppBundle\Entity\Nota
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_nota", referencedColumnName="id", nullable=false)
     * })
     */
    private $idNota;

    

    /**
     * @var \AppBundle\Entity\CondicionCalificacion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CondicionCalificacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_condicion_calificacion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idCondicionCalificacion;



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
     * Set idPorcentaje
     *
     * @param \AppBundle\Entity\Porcentaje $idPorcentaje
     * @return Calificacion
     */
    public function setIdPorcentaje(\AppBundle\Entity\Porcentaje $idPorcentaje = null)
    {
        $this->idPorcentaje = $idPorcentaje;

        return $this;
    }

    /**
     * Get idPorcentaje
     *
     * @return \AppBundle\Entity\Porcentaje 
     */
    public function getIdPorcentaje()
    {
        return $this->idPorcentaje;
    }

    /**
     * Set idNota
     *
     * @param \AppBundle\Entity\Nota $idNota
     * @return Calificacion
     */
    public function setIdNota(\AppBundle\Entity\Nota $idNota = null)
    {
        $this->idNota = $idNota;

        return $this;
    }

    /**
     * Get idNota
     *
     * @return \AppBundle\Entity\Nota 
     */
    public function getIdNota()
    {
        return $this->idNota;
    }

   
    /**
     * Set idCondicionCalificacion
     *
     * @param \AppBundle\Entity\CondicionCalificacion $idCondicionCalificacion
     * @return Calificacion
     */
    public function setIdCondicionCalificacion(\AppBundle\Entity\CondicionCalificacion $idCondicionCalificacion = null)
    {
        $this->idCondicionCalificacion = $idCondicionCalificacion;

        return $this;
    }

    /**
     * Get idCondicionCalificacion
     *
     * @return \AppBundle\Entity\CondicionCalificacion 
     */
    public function getIdCondicionCalificacion()
    {
        return $this->idCondicionCalificacion;
    }
}