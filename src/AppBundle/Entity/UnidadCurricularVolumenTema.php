<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tema
 *
 * @ORM\Table(name="unidad_curricular_volumen_tema")
 * @ORM\Entity
 */
class UnidadCurricularVolumenTema
{
    /**
     * @var string
     *
     * @ORM\Column(name="tema", type="string", length=50, nullable=false, options={"comment" = "nombre del estado"})
     */
    private $nombre;
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", length=2, nullable=false, options={"comment" = "orden del tema"})
     */
    private $orden;
    
    /**
     * @var text
     *
     * @ORM\Column(name="objetivo_general", type="text",  nullable=false, options={"comment" = "Objetivo General del tema"})
     */
    private $objetivoGeneral;

    /**
     * @ORM\ManyToOne(targetEntity="UnidadCurricularVolumen", inversedBy="temas")
     * @ORM\JoinColumn(name="id_unidad_curricular_volumen", referencedColumnName="id")
     */
    private $idUnidadCurricularVolumen;

   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del estado"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="estado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    


    /**
     * Get nombre
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nombre;
    }



    

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return UnidadCurricularVolumenTema
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
     * @return UnidadCurricularVolumenTema
     */
    public function setIdUnidadCurricularVolumen(\AppBundle\Entity\UnidadCurricularVolumen $idUnidadCurricularVolumen = null)
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
     * Set objetivoGeneral
     *
     * @param string $objetivoGeneral
     * @return UnidadCurricularVolumenTema
     */
    public function setObjetivoGeneral($objetivoGeneral)
    {
        $this->objetivoGeneral = $objetivoGeneral;

        return $this;
    }

    /**
     * Get objetivoGeneral
     *
     * @return string 
     */
    public function getObjetivoGeneral()
    {
        return $this->objetivoGeneral;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return UnidadCurricularVolumenTema
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }
}
