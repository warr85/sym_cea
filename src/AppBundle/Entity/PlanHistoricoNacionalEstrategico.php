<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 08:44 AM
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parroquia
 *
 * @ORM\Table(name="parroquia", uniqueConstraints={@ORM\UniqueConstraint(name="uq_parroquia", columns={"codigo"})}, indexes={@ORM\Index(name="fki_id_municipio_parroquia", columns={"id_municipio"})})
 * @ORM\Entity
 */
class Parroquia
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=40, nullable=false, options={"comment" = "nombre de parroquia"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="decimal", precision=6, scale=0, nullable=false, options={"comment" = "codigo parroquia"})
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador de la parroquia"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="parroquia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Municipio
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio", referencedColumnName="id", nullable=false)
     * })
     */
    private $idMunicipio;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Parroquia
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
     * @return Parroquia
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
     * Set idMunicipio
     *
     * @param \AppBundle\Entity\Municipio $idMunicipio
     * @return Parroquia
     */
    public function setIdMunicipio(\AppBundle\Entity\Municipio $idMunicipio = null)
    {
        $this->idMunicipio = $idMunicipio;

        return $this;
    }

    /**
     * Get idMunicipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getIdMunicipio()
    {
        return $this->idMunicipio;
    }
}
