<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 08:41 AM
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EjeParroquia
 *
 * @ORM\Table(name="eje_parroquia", uniqueConstraints={@ORM\UniqueConstraint(name="i_eje_parroquia", columns={"id_eje", "id_parroquia"})}, indexes={@ORM\Index(name="fki_id_parroquia", columns={"id_parroquia"}), @ORM\Index(name="fki_id_eje", columns={"id_eje"})})
 * @ORM\Entity
 */
class EjeParroquia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false , options={"comment" = "identificador del eje en una parroquia y viceversa"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="eje_parroquia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Parroquia
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Parroquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_parroquia", referencedColumnName="id", nullable=false)
     * })
     */
    private $idParroquia;

    /**
     * @var \AppBundle\Entity\Eje
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Eje")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_eje", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEje;



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
     * Set idParroquia
     *
     * @param \AppBundle\Entity\Parroquia $idParroquia
     * @return EjeParroquia
     */
    public function setIdParroquia(\AppBundle\Entity\Parroquia $idParroquia = null)
    {
        $this->idParroquia = $idParroquia;

        return $this;
    }

    /**
     * Get idParroquia
     *
     * @return \AppBundle\Entity\Parroquia
     */
    public function getIdParroquia()
    {
        return $this->idParroquia;
    }

    /**
     * Set idEje
     *
     * @param \AppBundle\Entity\Eje $idEje
     * @return EjeParroquia
     */
    public function setIdEje(\AppBundle\Entity\Eje $idEje = null)
    {
        $this->idEje = $idEje;

        return $this;
    }

    /**
     * Get idEje
     *
     * @return \AppBundle\Entity\Eje
     */
    public function getIdEje()
    {
        return $this->idEje;
    }


    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->getIdParroquia()->getIdMunicipio()->getIdEstado()->getNombre();
    }


    /**
     * Get nombre
     *
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getIdParroquia()->getNombre();
    }

}