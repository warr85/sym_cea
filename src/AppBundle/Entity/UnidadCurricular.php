<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnidadCurricular
 *
 * @ORM\Table(name="unidad_curricular", uniqueConstraints={@ORM\UniqueConstraint(name="unidad_curricular_nombre_key", columns={"nombre", "codigo"})})
 * @ORM\Entity
 */
class UnidadCurricular
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=250, nullable=false, options={"comment" = "registra el nombre de la unidad curricular"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=15, nullable=false, options={"comment" = "registra el codigo de la unidad curricular"})
     */

    private $codigo;


    /**
     * @var string
     *
     * @ORM\Column(name="horas", type="decimal", precision=2, scale=0, nullable=false, options={"comment" = "registra la cantidas de horas que son reglamentarias para una unidad curricular"})
     */
    private $horas;
    
     /**
     * @var string
     *
     * @ORM\Column(name="creditos", type="decimal", precision=2, scale=0, nullable=true, options={"comment" = "registra la cantidas de creditos de la UC si es que posee los mismos"})
     */
    private $creditos;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador unico de la unidad curricular"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="unidad_curricular_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return UnidadCurricular
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
     * Set codigo
     *
     * @param string $codigo
     * @return UnidadCurricular
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set horas
     *
     * @param string $horas
     * @return UnidadCurricular
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get horas
     *
     * @return string 
     */
    public function getHoras()
    {
        return $this->horas;
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
     * Set creditos
     *
     * @param string $creditos
     * @return UnidadCurricular
     */
    public function setCreditos($creditos)
    {
        $this->creditos = $creditos;

        return $this;
    }

    /**
     * Get creditos
     *
     * @return string 
     */
    public function getCreditos()
    {
        return $this->creditos;
    }
    
    /**
     * 
     * @return string
     */
    
    public function __toString() 
    {
        return $this->getNombre();
    }
}
