<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pfg
 *
 * @ORM\Table(name="pfg", uniqueConstraints={@ORM\UniqueConstraint(name="uq_programa", columns={"codigo", "nombre"})})
 * @ORM\Entity
 */
class Pfg
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=80, nullable=false, options={"comment" = "nombre programa de formacion de grado"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=8, nullable=false, options={"comment" = "codigo programa de formacion de grado"})
     */
    private $codigo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="carrera_ubv", type="boolean", nullable=false, options={"comment" = "Indica si la carreras o PFG es dictada por la UBV"})
     */
    private $carreraUbv;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del programa de formacion de grado"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="pfg_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Pfg
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
     * @return Pfg
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
     * Set carreraUbv
     *
     * @param boolean $carreraUbv
     * @return Pfg
     */
    public function setCarreraUbv($carreraUbv)
    {
        $this->carreraUbv = $carreraUbv;

        return $this;
    }

    /**
     * Get carreraUbv
     *
     * @return boolean 
     */
    public function getCarreraUbv()
    {
        return $this->carreraUbv;
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
     * 
     * @return string
     */
    
    public function __toString() {
        return $this->getNombre();
    }
}
