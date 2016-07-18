<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * MallaCurricular
 *
 * @ORM\Table(name="malla_curricular", uniqueConstraints={@ORM\UniqueConstraint(name="uq_codigo_malla_curricular", columns={"codigo"})}, indexes={@ORM\Index(name="fki_pfg_malla_curricular", columns={"id_pfg"}), @ORM\Index(name="fki_modalidad_malla_curricular", columns={"id_modalidad"})})
 * @ORM\Entity
 */
class MallaCurricular
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false, options={"comment" = "Nombre de la malla curricular"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=12, nullable=false, options={"comment" = "Codigo de la malla curricular (valor existente previo de crear este modelo de BD)"})
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la malla curricular"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="malla_curricular_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

   /**
     * @var \AppBundle\Entity\Pfg
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pfg")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pfg", referencedColumnName="id", nullable=false)
     * })
     */
    private $idPfg;

    /**
     * @var \AppBundle\Entity\Modalidad
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Modalidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_modalidad", referencedColumnName="id", nullable=false)
     * })
     */
    private $idModalidad;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return MallaCurricular
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
     * @return MallaCurricular
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

    /**
     * Set idPfg
     *
     * @param \AppBundle\Entity\Pfg $idPfg
     * @return MallaCurricular
     */
    public function setIdPfg(\AppBundle\Entity\Pfg $idPfg)
    {
        $this->idPfg = $idPfg;

        return $this;
    }

    /**
     * Get idPfg
     *
     * @return \AppBundle\Entity\Pfg 
     */
    public function getIdPfg()
    {
        return $this->idPfg;
    }

    /**
     * Set idModalidad
     *
     * @param \AppBundle\Entity\Modalidad $idModalidad
     * @return MallaCurricular
     */
    public function setIdModalidad(\AppBundle\Entity\Modalidad $idModalidad)
    {
        $this->idModalidad = $idModalidad;

        return $this;
    }

    /**
     * Get idModalidad
     *
     * @return \AppBundle\Entity\Modalidad 
     */
    public function getIdModalidad()
    {
        return $this->idModalidad;
    }
    
    public function __toString() {
        return $this->getNombre();
    }
}
