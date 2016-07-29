<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nota
 *
 * @ORM\Table(name="nota", indexes={@ORM\Index(name="fki_id_escala_nota", columns={"id_escala"}), @ORM\Index(name="IDX_C8D03E0D66B9A058", columns={"id_nomenclatura_nota"})})
 * @ORM\Entity
 */
class Nota
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la nota"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="nota_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\NomenclaturaNota
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\NomenclaturaNota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_nomenclatura_nota", referencedColumnName="id", nullable=false)
     * })
     */
    private $idNomenclaturaNota;

    

    /**
     * @var \AppBundle\Entity\Escala
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Escala")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_escala", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEscala;



    

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
     * Set idNomenclaturaNota
     *
     * @param \AppBundle\Entity\NomenclaturaNota $idNomenclaturaNota
     * @return Nota
     */
    public function setIdNomenclaturaNota(\AppBundle\Entity\NomenclaturaNota $idNomenclaturaNota)
    {
        $this->idNomenclaturaNota = $idNomenclaturaNota;

        return $this;
    }

    /**
     * Get idNomenclaturaNota
     *
     * @return \AppBundle\Entity\NomenclaturaNota 
     */
    public function getIdNomenclaturaNota()
    {
        return $this->idNomenclaturaNota;
    }

    /**
     * Set idEscala
     *
     * @param \AppBundle\Entity\Escala $idEscala
     * @return Nota
     */
    public function setIdEscala(\AppBundle\Entity\Escala $idEscala)
    {
        $this->idEscala = $idEscala;

        return $this;
    }

    /**
     * Get idEscala
     *
     * @return \AppBundle\Entity\Escala 
     */
    public function getIdEscala()
    {
        return $this->idEscala;
    }
}
