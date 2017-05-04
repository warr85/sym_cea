<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 08:40 AM
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstitucionAsociada
 *
 * @ORM\Table(name="institucion_asociada", indexes={@ORM\Index(name="fki_institucion_institucion_central", columns={"id_institucion_central"}), @ORM\Index(name="fki_institucion_institucion_asociada", columns={"id_institucion_asociada"})})
 * @ORM\Entity
 */
class InstitucionAsociada
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=250, nullable=true, options={"comment" = "Nombre de la institucion.Debe ser unico, las instituciones que compartan y/o alternen el mismo espacio fisico deben diferenciarse por su nombre. Ej: Alde-Bolivar-Dia, Alde-Bolivar-Noche"})
     */
    private $nombre;



    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la institucion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="institucion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\TipoInstitucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Institucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_institucion_central", referencedColumnName="id", nullable=false)
     * })
     */
    private $idInstitucionCentral;

    /**
     * @var \AppBundle\Entity\EjeParroquia
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Institucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_institucion_asociada", referencedColumnName="id", nullable=false)
     * })
     */
    private $idInstitucionAsociada;






    public function __toString(){
        return $this->getNombre();
    }



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return InstitucionAsociada
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
     * Set idInstitucionCentral
     *
     * @param \AppBundle\Entity\Institucion $idInstitucionCentral
     * @return InstitucionAsociada
     */
    public function setIdInstitucionCentral(\AppBundle\Entity\Institucion $idInstitucionCentral)
    {
        $this->idInstitucionCentral = $idInstitucionCentral;

        return $this;
    }

    /**
     * Get idInstitucionCentral
     *
     * @return \AppBundle\Entity\Institucion 
     */
    public function getIdInstitucionCentral()
    {
        return $this->idInstitucionCentral;
    }

    /**
     * Set idInstitucionAsociada
     *
     * @param \AppBundle\Entity\Institucion $idInstitucionAsociada
     * @return InstitucionAsociada
     */
    public function setIdInstitucionAsociada(\AppBundle\Entity\Institucion $idInstitucionAsociada)
    {
        $this->idInstitucionAsociada = $idInstitucionAsociada;

        return $this;
    }

    /**
     * Get idInstitucionAsociada
     *
     * @return \AppBundle\Entity\Institucion 
     */
    public function getIdInstitucionAsociada()
    {
        return $this->idInstitucionAsociada;
    }
}
