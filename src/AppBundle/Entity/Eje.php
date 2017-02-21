<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 08:43 AM
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eje
 *
 * @ORM\Table(name="eje", uniqueConstraints={@ORM\UniqueConstraint(name="uq_eje", columns={"codigo", "nombre"})})
 * @ORM\Entity
 */
class Eje
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false, options={"comment" = "Nombre del eje (Generalmente el nombre de un estado)"})
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="abreviacion", type="string", length=3, nullable=false, options={"comment" = "Abreviacion del Eje"})
     */
    private $abreviacion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="decimal", precision=2, scale=0, nullable=false, options={"comment" = "Codigo formado por la union de los codigos de cada estado que compone al eje"})
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false , options={"comment" = "Identificador de registro"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="eje_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Eje
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
     * @return Eje
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Set abreviacion
     *
     * @param string $abreviacion
     * @return Eje
     */
    public function setAbreviacion($abreviacion)
    {
        $this->abreviacion = $abreviacion;

        return $this;
    }

    /**
     * Get abreviacion
     *
     * @return string 
     */
    public function getAbreviacion()
    {
        return $this->abreviacion;
    }
}
