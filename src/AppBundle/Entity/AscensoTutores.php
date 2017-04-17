<?php
/**
 * Created by PhpStorm.
 * User: Wilmer Ramones
 * Date: 29/06/16
 * Time: 07:52 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AscensoTutores
 *
 * @ORM\Table(name="ascenso_tutores", uniqueConstraints={@ORM\UniqueConstraint(name="ascenso_id_tutor_id", columns={"id_ascenso", "id_tutor"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AscensoTutores
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la Tabla"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="adscripcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    
	/**
     * @var \AppBundle\Entity\Ascenso
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ascenso", inversedBy="tutores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ascenso", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idAscenso;


    /**
     * @var \AppBundle\Entity\TutoresAscenso
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TutoresAscenso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tutor", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idTutor;



    /**
     * @var \AppBundle\Entity\EstatusTutor
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EstatusTutor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus_tutor", referencedColumnName="id", nullable=true)
     * })
     */
    protected $idEstatusTutor;


     /**
     * @var \AppBundle\Entity\Estatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estatus", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idEstatus;
    
       
    


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
     * Set idAscenso
     *
     * @param \AppBundle\Entity\Ascenso $idAscenso
     * @return AscensoTutores
     */
    public function setIdAscenso(\AppBundle\Entity\Ascenso $idAscenso)
    {
        $this->idAscenso = $idAscenso;

        return $this;
    }

    /**
     * Get idAscenso
     *
     * @return \AppBundle\Entity\Ascenso 
     */
    public function getIdAscenso()
    {
        return $this->idAscenso;
    }

    /**
     * Set idTutor
     *
     * @param \AppBundle\Entity\TutoresAscenso $idTutor
     * @return AscensoTutores
     */
    public function setIdTutor(\AppBundle\Entity\TutoresAscenso $idTutor)
    {
        $this->idTutor = $idTutor;

        return $this;
    }

    /**
     * Get idTutor
     *
     * @return \AppBundle\Entity\TutoresAscenso 
     */
    public function getIdTutor()
    {
        return $this->idTutor;
    }

    /**
     * Set idEstatusTutor
     *
     * @param \AppBundle\Entity\EstatusTutor $idEstatusTutor
     * @return AscensoTutores
     */
    public function setIdEstatusTutor(\AppBundle\Entity\EstatusTutor $idEstatusTutor)
    {
        $this->idEstatusTutor = $idEstatusTutor;

        return $this;
    }

    /**
     * Get idEstatusTutor
     *
     * @return \AppBundle\Entity\EstatusTutor 
     */
    public function getIdEstatusTutor()
    {
        return $this->idEstatusTutor;
    }

    /**
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return AscensoTutores
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
}
