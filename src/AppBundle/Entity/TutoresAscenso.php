<?php
/**
 * Creado por:
 * User: Wilmer Ramones
 * Date: 16/01/17
 * Time: 08:25 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tutores Ascenso
 *
 * @ORM\Table(name="tutores_ascenso", uniqueConstraints={@ORM\UniqueConstraint(name="uq_cedula", columns={"cedula_pasaporte"})})
 * @ORM\Entity
 */
class TutoresAscenso
{
    
    /**
     * @var \AppBundle\Entity\DocumentoIdentidad
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DocumentoIdentidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_documento_identidad", referencedColumnName="id", nullable=false)
     * })
     */
    private $idDocumentoentidad;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="cedula_pasaporte", type="string", length=15, nullable=false, options={"comment" = "Numero de cedula o pasaporte de la persona"})
     */
    private $cedulaPasaporte;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="correo_electronico", type="string", length=80, nullable=true, options={"comment" = "nombre de correo electronico de la apersona"})
     */
    private $correoElectronico;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255, nullable=false, options={"comment" = "Nombres del Tutor"})
     */
    private $nombres;
    
    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255, nullable=false, options={"comment" = "Apellidos del Tutor"})
     */
    private $apellidos;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="institucion", type="string", length=255, nullable=true, options={"comment" = "Instituto educativo de donde viene es el tutor"})
     */
    private $institucion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del tutor"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="genero_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    
    /**
     * @var \AppBundle\Entity\Escalafones
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Escalafones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_escala", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idEscala;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ascenso", inversedBy="tutoresAscenso")
     * @ORM\JoinColumn(name="ascenso_id", referencedColumnName="id")
     */
    private $ascenso;

    

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nombres . " " . $this->apellidos;
    }



    /**
     * Set cedulaPasaporte
     *
     * @param string $cedulaPasaporte
     * @return TutoresAscenso
     */
    public function setCedulaPasaporte($cedulaPasaporte)
    {
        $this->cedulaPasaporte = $cedulaPasaporte;

        return $this;
    }

    /**
     * Get cedulaPasaporte
     *
     * @return string 
     */
    public function getCedulaPasaporte()
    {
        return $this->cedulaPasaporte;
    }

    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     * @return TutoresAscenso
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string 
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return TutoresAscenso
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return TutoresAscenso
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
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
     * Set idDocumentoentidad
     *
     * @param \AppBundle\Entity\DocumentoIdentidad $idDocumentoentidad
     * @return TutoresAscenso
     */
    public function setIdDocumentoentidad(\AppBundle\Entity\DocumentoIdentidad $idDocumentoentidad)
    {
        $this->idDocumentoentidad = $idDocumentoentidad;

        return $this;
    }

    /**
     * Get idDocumentoentidad
     *
     * @return \AppBundle\Entity\DocumentoIdentidad 
     */
    public function getIdDocumentoentidad()
    {
        return $this->idDocumentoentidad;
    }

    /**
     * Set idEscala
     *
     * @param \AppBundle\Entity\Escalafones $idEscala
     * @return TutoresAscenso
     */
    public function setIdEscala(\AppBundle\Entity\Escalafones $idEscala)
    {
        $this->idEscala = $idEscala;

        return $this;
    }

    /**
     * Get idEscala
     *
     * @return \AppBundle\Entity\Escalafones 
     */
    public function getIdEscala()
    {
        return $this->idEscala;
    }

    /**
     * Set ascenso
     *
     * @param \AppBundle\Entity\Ascenso $ascenso
     * @return TutoresAscenso
     */
    public function setAscenso(\AppBundle\Entity\Ascenso $ascenso = null)
    {
        $this->ascenso = $ascenso;

        return $this;
    }

    /**
     * Get ascenso
     *
     * @return \AppBundle\Entity\Ascenso 
     */
    public function getAscenso()
    {
        return $this->ascenso;
    }

    /**
     * Set institucion
     *
     * @param string $institucion
     * @return TutoresAscenso
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * Get institucion
     *
     * @return string 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }
}
