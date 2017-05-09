<?php
/**
 * Created by PhpStorm.
 * User: Wilmer Ramones
 * Date: 29/06/16
 * Time: 07:52 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AscensoPertinencia
 *
 * @ORM\Table(name="ascenso_pertinencia")
 * @ORM\Entity
 */
class AscensoPertinencia
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la Tabla"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="adscripcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    
	/**
     * @var \AppBundle\Entity\Ascenso
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ascenso", inversedBy="tutores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ascenso", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idAscenso;



    /**
     * @ORM\Column(name="titulo_pertinencia", type="string", nullable=false, options={"comment" = "Título del informe de pertinencia"})
     */
    private $tituloPertinencia;

    /**
     * @ORM\Column(name="lugar_pertinencia", type="string", nullable=false, options={"comment" = "Lugar donde defendió"})
     */
    private $lugarPertinencia;


    /** @ORM\Column(type="date", name="fecha_defensa", nullable=false, options={"comment" = "Fecha de la defensa"})
     * @Assert\Date()
     */
    private $fechaDefensa;




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
     * Set tituloPertinencia
     *
     * @param string $tituloPertinencia
     * @return AscensoPertinencia
     */
    public function setTituloPertinencia($tituloPertinencia)
    {
        $this->tituloPertinencia = $tituloPertinencia;

        return $this;
    }

    /**
     * Get tituloPertinencia
     *
     * @return string 
     */
    public function getTituloPertinencia()
    {
        return $this->tituloPertinencia;
    }

    /**
     * Set lugarPertinencia
     *
     * @param string $lugarPertinencia
     * @return AscensoPertinencia
     */
    public function setLugarPertinencia($lugarPertinencia)
    {
        $this->lugarPertinencia = $lugarPertinencia;

        return $this;
    }

    /**
     * Get lugarPertinencia
     *
     * @return string 
     */
    public function getLugarPertinencia()
    {
        return $this->lugarPertinencia;
    }

    /**
     * Set fechaDefensa
     *
     * @param \DateTime $fechaDefensa
     * @return AscensoPertinencia
     */
    public function setFechaDefensa($fechaDefensa)
    {
        $this->fechaDefensa = $fechaDefensa;

        return $this;
    }

    /**
     * Get fechaDefensa
     *
     * @return \DateTime 
     */
    public function getFechaDefensa()
    {
        return $this->fechaDefensa;
    }

    /**
     * Set idAscenso
     *
     * @param \AppBundle\Entity\Ascenso $idAscenso
     * @return AscensoPertinencia
     */
    public function setIdAscenso(\AppBundle\Entity\Ascenso $idAscenso)
    {
        $this->idAscenso = $idAscenso;

        return $this;
    }

    /**
     * Get idAscenso
     *
     * @return \AppBundle\Entity\Ascenso 
     */
    public function getIdAscenso()
    {
        return $this->idAscenso;
    }
}
