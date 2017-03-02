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

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Memorando;
use AppBundle\Entity\DocenteServicio;

/**
 * Description of AntiguedadController
 *
 * @author ubv-cipee
 */
class AntiguedadController extends Controller {
    
     /**
     * Muestra la página donde explica brevemente el reconocimiento de Antiguedad
     * y permite realizar la solicitud
     *
     * @Route("/servicios/antiguedad/", name="cea_solicitudes_recocimiento_antiguedad")
     * @Method({"GET", "POST"})
     */
    public function serviciosAntiguedadIndexAction(){
        
        $oposicion = $this->getDoctrine()->getRepository("AppBundle:DocumentosVerificados")->findOneBy(array(
            'idRolInstitucion' => $this->getUser()->getIdRolInstitucion(),
            'idTipoDocumentos' => 4
        ));
        
        if (!$oposicion ){
            $this->addFlash('danger', 'Estimado docente el CEA le informa que para gozar de este servicio, debe haber aprobado concurso de oposición.');
            return $this->redirect($this->generateUrl('cea_index'));   
        }
        
        $servicio = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
            'idRolInstitucion' => $this->getUser()->getIdRolInstitucion(),
            'idServicioCe'  => 1
        ));
        
        if(!$servicio){
                return $this->render('solicitudes/reconocimiento_antiguedad.html.twig');
        }else{
            $this->addFlash('notice', 'Ya usted ha realizado la solicitud de reconocimiento de antiguedad.');
            return $this->redirect($this->generateUrl('servicios_index'));   
        }
        
        
        
    }
    
    
    /**
     * Muestra la página donde explica brevemente el reconocimiento de Antiguedad
     * y permite realizar la solicitud
     *
     * @Route("/mis_servicios/antiguedad/imprimir/{id}", name="servicio_antiguedad_imprimir")
     * @Method({"GET", "POST"})
     */
    public function serviciosAntiguedadImprimirAction(DocenteServicio $antiguedad){
        
       
       
       if($antiguedad->getIdEstatus()->getId() == 1){
         $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($antiguedad->getIdRolInstitucion());
         $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneByIdRolInstitucion($antiguedad->getIdRolInstitucion());
         $idRol = $escala->getIdRolInstitucion()->getId();
        $stmt = $this->getDoctrine()->getManager()
        ->getConnection()
        ->prepare("select age(e.fecha_escala, a.fecha_ingreso),
            date_part('year',age(e.fecha_escala, a.fecha_ingreso)) as anos,
            date_part('month',age(e.fecha_escala, a.fecha_ingreso)) as meses,
            date_part('day',age(e.fecha_escala, a.fecha_ingreso)) as dias
            FROM docente_escala as e
            INNER JOIN solicitud_adscripcion as a 
            ON a.id_rol_institucion = e.id_rol_institucion
            WHERE e.id_tipo_escala = '1' AND a.id_rol_institucion = $idRol");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $recon = $result[0]['anos'] . " años " . $result[0]['meses'] . " meses y " . $result[0]['dias'] . " días.";
            
            $correlativo = $this->getDoctrine()->getRepository('AppBundle:Memorando')->findOneByIdDocenteServicio($antiguedad->getId());
            
            if(!$correlativo){
                    $correlativo = $this->getDoctrine()->getRepository('AppBundle:Memorando')->findOneBy(
                         array('ano'=> date("Y")), 
                        array('id' => 'DESC')
                    );
                    $numero = 1;
                    if ($correlativo) $numero = $correlativo->getCorrelativo() + 1;

                    $memo = new Memorando();
                    $memo->setCorrelativo($numero);
                    $memo->setIdDocenteServicio($antiguedad);
                    $memo->setAno(date("Y"));
                    $memo->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(1));

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($memo);
                    $em->flush();
                    $memorando = $memo->getCorrelativo() . "-" . $memo->getAno();
            }else{
                $memorando = $correlativo->getCorrelativo() . "-" . $correlativo->getAno();
            }
     
            return $this->render('memorando/antiguedad.html.twig', array(
                'antiguedad'    =>  $antiguedad,
                'adscripcion'   =>  $adscripcion,
                'escala'        =>  $escala,
                'diferencia'    =>  $recon,
                'correlativo'   =>  $memorando
            ));
        
        
       }else{
           
           $this->addFlash('danger', 'No Puede Imprimir el reconocimiento de Antiguedad hasta que esté aprobado por el coordinador del CEA.');
       
        $servicios = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        
        
        return $this->render('solicitudes/index.html.twig', array(
            'servicios' => $servicios,
            'adscripcion' => $adscripcion
        ));
           
       }
        
        
        
    }
    
    
    
    
     /**
     * Muestra la página donde explica brevemente el reconocimiento de Antiguedad
     * y permite realizar la solicitud
     *
     * @Route("/solicitudes/antiguedad/crear/", name="cea_crear_servicio_antiguedad")
     * @Method({"GET", "POST"})
     */
    public function solicitudesAntiguedadCrearAction(){
        
        $servicios = new DocenteServicio();
        
        $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(1));
        $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($servicios);
        $em->flush();
        
        $this->addFlash('notice', 'Solicitud Creada Correctamente, en lo que la solicitud sea aprobada, se le notificará por correo.');
        
        return $this->render('solicitudes/reconocimiento_antiguedad.html.twig');
        
    }
    //put your code here
}
