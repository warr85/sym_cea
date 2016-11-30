<?php
/**
 * Created by PhpStorm.
 * User: Wilmer Ramones
 * Date: 29/06/16
 * Time: 07:52 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Escalafones
 *
 * @ORM\Table(name="escalafones", uniqueConstraints={@ORM\UniqueConstraint(name="uq_nombre_escala", columns={"nombre"})})
 * @ORM\Entity
 */
class Escalafones
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false, options={"comment" = "Nombre del escalafon"})
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador del escalafon"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="escalafon_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="tiempo", type="integer", nullable=false, options={"comment" = "Tiempo necesario para obtener la escala"})
     */
    private $tiempo;
    
   
    


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Escalafon
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
     * Get nombre
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nombre;
    }
    

    /**
     * Set tiempo
     *
     * @param integer $tiempo
     * @return Escalafones
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return integer 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }
}
