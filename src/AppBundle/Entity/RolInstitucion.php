<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 08:38 AM
 */


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RolInstitucion
 *
 * @ORM\Table(name="rol_institucion", uniqueConstraints={@ORM\UniqueConstraint(name="i_rol_institucion", columns={"id_institucion", "id_rol"})}, indexes={@ORM\Index(name="fki_estatus_rol_institucion", columns={"id_estatus"}), @ORM\Index(name="fki_rol_rol_institucion", columns={"id_rol"}), @ORM\Index(name="IDX_E530B3F2EF433A34", columns={"id_institucion"})})
 * @ORM\Entity
 */
class RolInstitucion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador de registro rol institucion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="rol_institucion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Rol
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol", referencedColumnName="id", nullable=false)
     * })
     */
    private $idRol;

    /**
     * @var \AppBundle\Entity\Institucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Institucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idInstitucion;

    /**
     * @var \AppBundle\Entity\Estatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus", referencedColumnName="id", nullable=false)
     * })
     */
    private $idEstatus;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AdscripcionPida", mappedBy="idRolInstitucion")
     */
    private $pida;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocenteEscala", mappedBy="idRolInstitucion")
     */
    private $escalafones;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ascenso", mappedBy="idRolInstitucion")
     */
    private $ascensos;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocumentosVerificados", mappedBy="idRolInstitucion")
     */
    private $documentosVerificados;


    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Adscripcion", mappedBy="idRolInstitucion")
     */
    private $adscripcion;



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
     * Set idRol
     *
     * @param \AppBundle\Entity\Rol $idRol
     * @return RolInstitucion
     */
    public function setIdRol(\AppBundle\Entity\Rol $idRol = null)
    {
        $this->idRol = $idRol;

        return $this;
    }

    /**
     * Get idRol
     *
     * @return \AppBundle\Entity\Rol
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * Set idInstitucion
     *
     * @param \AppBundle\Entity\Institucion $idInstitucion
     * @return RolInstitucion
     */
    public function setIdInstitucion(\AppBundle\Entity\Institucion $idInstitucion = null)
    {
        $this->idInstitucion = $idInstitucion;

        return $this;
    }

    /**
     * Get idInstitucion
     *
     * @return \AppBundle\Entity\Institucion
     */
    public function getIdInstitucion()
    {
        return $this->idInstitucion;
    }

    /**
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return RolInstitucion
     */
    public function setIdEstatus(\AppBundle\Entity\Estatus $idEstatus = null)
    {
        $this->idEstatus = $idEstatus;

        return $this;
    }

    /**
     * Get idEstatus
     *
     * @return \AppBundle\Entity\Estatus
     */
    public function getIdEstatus()
    {
        return $this->idEstatus;
    }


    /**
     * Get __toString
     * @return string
     *
     */
    public function __toString()
    {
        return $this->getIdRol()->getIdPersona()->getPrimerNombre() .  ", " . $this->getIdRol()->getIdPersona()->getPrimerApellido();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pida = new ArrayCollection();
        $this->escalafones = new ArrayCollection();
        $this->ascensos = new ArrayCollection();
        $this->documentosVerificados = new ArrayCollection();

    }

    /**
     * Add pida
     *
     * @param \AppBundle\Entity\AdscripcionPida $pida
     * @return RolInstitucion
     */
    public function addPida(\AppBundle\Entity\AdscripcionPida $pida)
    {
        $this->pida[] = $pida;

        return $this;
    }

    /**
     * Remove pida
     *
     * @param \AppBundle\Entity\AdscripcionPida $pida
     */
    public function removePida(\AppBundle\Entity\AdscripcionPida $pida)
    {
        $this->pida->removeElement($pida);
    }

    /**
     * Get pida
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPida()
    {
        return $this->pida;
    }



    /**
     * Set adscripcion
     *
     * @param \AppBundle\Entity\Adscripcion $adscripcion
     * @return RolInstitucion
     */
    public function setAdscripcion(\AppBundle\Entity\Adscripcion $adscripcion = null)
    {
        $this->adscripcion = $adscripcion;

        return $this;
    }

    /**
     * Get adscripcion
     *
     * @return \AppBundle\Entity\Adscripcion 
     */
    public function getAdscripcion()
    {
        return $this->adscripcion;
    }

    /**
     * Add escalafones
     *
     * @param \AppBundle\Entity\DocenteEscala $escalafones
     * @return RolInstitucion
     */
    public function addEscalafone(\AppBundle\Entity\DocenteEscala $escalafones)
    {
        $this->escalafones[] = $escalafones;

        return $this;
    }

    /**
     * Remove escalafones
     *
     * @param \AppBundle\Entity\DocenteEscala $escalafones
     */
    public function removeEscalafone(\AppBundle\Entity\DocenteEscala $escalafones)
    {
        $this->escalafones->removeElement($escalafones);
    }

    /**
     * Get escalafones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEscalafones()
    {
        return $this->escalafones;
    }

    /**
     * Add ascensos
     *
     * @param \AppBundle\Entity\Ascenso $ascensos
     * @return RolInstitucion
     */
    public function addAscenso(\AppBundle\Entity\Ascenso $ascensos)
    {
        $this->ascensos[] = $ascensos;

        return $this;
    }

    /**
     * Remove ascensos
     *
     * @param \AppBundle\Entity\Ascenso $ascensos
     */
    public function removeAscenso(\AppBundle\Entity\Ascenso $ascensos)
    {
        $this->ascensos->removeElement($ascensos);
    }

    /**
     * Get ascensos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAscensos()
    {
        return $this->ascensos;
    }

    /**
     * Add documentosVerificados
     *
     * @param \AppBundle\Entity\DocumentosVerificados $documentosVerificados
     * @return RolInstitucion
     */
    public function addDocumentosVerificado(\AppBundle\Entity\DocumentosVerificados $documentosVerificados)
    {
        $this->documentosVerificados[] = $documentosVerificados;

        return $this;
    }

    /**
     * Remove documentosVerificados
     *
     * @param \AppBundle\Entity\DocumentosVerificados $documentosVerificados
     */
    public function removeDocumentosVerificado(\AppBundle\Entity\DocumentosVerificados $documentosVerificados)
    {
        $this->documentosVerificados->removeElement($documentosVerificados);
    }

    /**
     * Get documentosVerificados
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocumentosVerificados()
    {
        return $this->documentosVerificados;
    }
}
