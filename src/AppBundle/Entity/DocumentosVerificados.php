<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DocumentosVerificados
 *
 * @ORM\Table(name="documentos_verificados")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class DocumentosVerificados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la inscripcion del estudiante"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="documentos_verificados_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;




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
     * @var \AppBundle\Entity\RolInstitucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RolInstitucion", inversedBy="documentosVerificados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    private $idRolInstitucion;


    /**
     * @var \AppBundle\Entity\TipoDocumentos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoDocumentos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_documentos", referencedColumnName="id", nullable=false)
     * })
     */
    private $idTipoDocumentos;


    /**
     * @var \AppBundle\Entity\DocenteServicio
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DocenteServicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_servicio", referencedColumnName="id", nullable=false)
     * })
     */
    private $idServicio;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="date", nullable=false, options={"comment" = "fecha de creacion de la inscripcion"})
     */
    protected $created;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ultima_actualizacion", type="date", nullable=false, options={"comment" = "fecha de actualizacion de la inscripcion"})
     */
    protected $modified;


    /**
     * @ORM\Column(type="string", nullable=false, options={"comment" = "ubicacion del documento"})
     *
     * @Assert\NotBlank(message="Debe cargar su digital de constancia.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $ubicacion;



    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {

        $this->created = new \DateTime();
        $this->modified = new \DateTime();

    }


    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->modified = new \DateTime();

    }




    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Inscripcion
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return Inscripcion
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
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
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return DocumentosVerificados
     */
    public function setIdEstatus(\AppBundle\Entity\Estatus $idEstatus)
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
     * Set idRolInstitucion
     *
     * @param \AppBundle\Entity\RolInstitucion $idRolInstitucion
     * @return DocumentosVerificados
     */
    public function setIdRolInstitucion(\AppBundle\Entity\RolInstitucion $idRolInstitucion)
    {
        $this->idRolInstitucion = $idRolInstitucion;

        return $this;
    }

    /**
     * Get idRolInstitucion
     *
     * @return \AppBundle\Entity\RolInstitucion 
     */
    public function getIdRolInstitucion()
    {
        return $this->idRolInstitucion;
    }

    /**
     * Set idTipoDocumentos
     *
     * @param \AppBundle\Entity\TipoDocumentos $idTipoDocumentos
     * @return DocumentosVerificados
     */
    public function setIdTipoDocumentos(\AppBundle\Entity\TipoDocumentos $idTipoDocumentos)
    {
        $this->idTipoDocumentos = $idTipoDocumentos;

        return $this;
    }

    /**
     * Get idTipoDocumentos
     *
     * @return \AppBundle\Entity\TipoDocumentos 
     */
    public function getIdTipoDocumentos()
    {
        return $this->idTipoDocumentos;
    }





    /**
     * @return mixed
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    /**
     * Set idServicio
     *
     * @param \AppBundle\Entity\DocenteServicio $idServicio
     * @return DocumentosVerificados
     */
    public function setIdServicio(\AppBundle\Entity\DocenteServicio $idServicio)
    {
        $this->idServicio = $idServicio;

        return $this;
    }

    /**
     * Get idServicio
     *
     * @return \AppBundle\Entity\DocenteServicio 
     */
    public function getIdServicio()
    {
        return $this->idServicio;
    }
}
