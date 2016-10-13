<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanObjetivoHistorico
 *
 * @ORM\Table(name="plan_objetivo_historico", uniqueConstraints={@ORM\UniqueConstraint(name="uq_numero", columns={"numero", "nombre"})})
 * @ORM\Entity
 */
class PlanObjetivoHistorico
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false, options={"comment" = "nombre del plan_objetivo_historico"})
     */
    private $nombre;

    
    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=false, options={"comment" = "numero del orden del gran Objetivo Histórico"})
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "identificador del plan_objetivo_historico"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="estado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    

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
     * Set nombre
     *
     * @param string $nombre
     * @return PlanObjetivoHistorico
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
     * Set numero
     *
     * @param integer $numero
     * @return PlanObjetivoHistorico
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
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
}
