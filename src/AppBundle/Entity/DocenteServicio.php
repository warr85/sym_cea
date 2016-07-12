<?php

/*
 * Copyright (C) 2016 ubv-cipee
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DocenteServicio
 *
 * @ORM\Table(name="docente_servicio", uniqueConstraints={@ORM\UniqueConstraint(name="docente_servicio_id_rol_institucion_key", columns={"id_rol_institucion"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class DocenteServicio {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment" = "Identificador de la Adscripcion"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="adscripcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    
    
	/**
     * @var \AppBundle\Entity\RolInstitucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RolInstitucion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol_institucion", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idRolInstitucion;
    
    
    /**
     * @var \AppBundle\Entity\ServiciosCe
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ServiciosCe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_servicio_ce", referencedColumnName="id", nullable=false)
     * })
     */
    protected $idServicioCe;
    
    /** @ORM\Column(type="date", nullable=false, options={"comment" = "Fecha de creación de la solicitud"})  
     /**
     * @Assert\Date()
     */      
    private $fecha_solicitud;
    
    /** @ORM\Column(type="date", nullable=false, options={"comment" = "Fecha de actualizada la solicitud"})  
     /**
     * @Assert\Date()
     */      
    private $fecha_ultima_actualizacion;
    
    
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
     * Set idRolInstitucion
     *
     * @param \AppBundle\Entity\RolInstitucion $idRolInstitucion
     * @return Usuarios
     */
    public function setIdRolInstitucion(\AppBundle\Entity\RolInstitucion $idRolInstitucion = null)
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
   * @ORM\PrePersist
   */
    public function setFechaSolicitud()
    {
	    $this->fecha_solicitud = new \DateTime();
	    $this->fecha_ultima_actualizacion = new \DateTime();
    }
    
    public function getFechaSolicitud()
    {
	    return $this->fecha_solicitud;
    }

    /**
    * @ORM\PreUpdate
    */
    public function setFechaUltimaActualizacion()
    {
        $this->fecha_utlima_actualizacion = new \DateTime();
    }
    
    
    /**
     * Set idEstatus
     *
     * @param \AppBundle\Entity\Estatus $idEstatus
     * @return Estatus
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
     * Set $idServicioCe
     *
     * @param \AppBundle\Entity\ServiciosCe $idEstatus
     * @return ServicioCe
     */
    public function setIdServicioCe(\AppBundle\Entity\ServiciosCe $idServicioCe = null)
    {
        $this->idServicioCe = $idServicioCe;

        return $this;
    }

    /**
     * Get $idServicioCe
     *
     * @return \AppBundle\Entity\ServiciosCe
     */
    public function getIdServicioCe()
    {
        return $this->idServicioCe;
    }
}
