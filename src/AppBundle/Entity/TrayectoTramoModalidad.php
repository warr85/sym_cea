<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrayectoTramoModalidad
 *
 * @ORM\Table(name="trayecto_tramo_modalidad", uniqueConstraints={@ORM\UniqueConstraint(name="i_trayecto_tramo_modalidad", columns={"id_trayecto", "id_tramo"})}, indexes={@ORM\Index(name="fki_modalidad_trayecto_tramo_modalidad", columns={"id_modalidad"}), @ORM\Index(name="fki_tramo_trayecto_tramo_modalidad", columns={"id_tramo"}), @ORM\Index(name="IDX_AE063967814981A6", columns={"id_trayecto"})})
 * @ORM\Entity
 */
class TrayectoTramoModalidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del trayecto_tramo_modalidad"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="trayecto_tramo_modalidad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Trayecto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trayecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_trayecto", referencedColumnName="id", nullable=false)
     * })
     */
    private $idTrayecto;

    /**
     * @var \AppBundle\Entity\Tramo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tramo", referencedColumnName="id", nullable=false)
     * })
     */
    private $idTramo;

    /**
     * @var \AppBundle\Entity\Modalidad
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modalidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_modalidad", referencedColumnName="id", nullable=false)
     * })
     */
    private $idModalidad;



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
     * Set idTrayecto
     *
     * @param \AppBundle\Entity\Trayecto $idTrayecto
     * @return TrayectoTramoModalidad
     */
    public function setIdTrayecto(\AppBundle\Entity\Trayecto $idTrayecto)
    {
        $this->idTrayecto = $idTrayecto;

        return $this;
    }

    /**
     * Get idTrayecto
     *
     * @return \AppBundle\Entity\Trayecto 
     */
    public function getIdTrayecto()
    {
        return $this->idTrayecto;
    }

    /**
     * Set idTramo
     *
     * @param \AppBundle\Entity\Tramo $idTramo
     * @return TrayectoTramoModalidad
     */
    public function setIdTramo(\AppBundle\Entity\Tramo $idTramo)
    {
        $this->idTramo = $idTramo;

        return $this;
    }

    /**
     * Get idTramo
     *
     * @return \AppBundle\Entity\Tramo 
     */
    public function getIdTramo()
    {
        return $this->idTramo;
    }

    /**
     * Set idModalidad
     *
     * @param \AppBundle\Entity\Modalidad $idModalidad
     * @return TrayectoTramoModalidad
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
}
