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
use AppBundle\Entity\EstadoAcademico;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of EstadoAcademicoController
 *
 * @author ubv-cipee
 */
class EstadoAcademicoController extends Controller {
    
     /**
     * Muestra la página donde explica brevemente el reconocimiento de EstadoAcademico
     * y permite realizar la solicitud
     *
     * @Route("/servicios/estado_academico/", name="cea_solicitudes_estado_academico")
     * @Method({"GET", "POST"})
     */
    public function serviciosEstadoAcademicoIndexAction(Request $request){
        
       
        $ea = new EstadoAcademico();
        $form = $this->createForm('AppBundle\Form\EstadoAcademicoType', $ea);        
        $form->handleRequest($request);
        // get the value of a $_POST parameter
        if ($form->isSubmitted() && $form->isValid()) {
            
            $existe = $this->getDoctrine()->getRepository('AppBundle:EstadoAcademico')->findOneBy(array(
                'idRolInstitucion'          => $this->getUser()->getIdRolInstitucion(),
                'idOfertaMallaCurricular'   => $ea->getIdOfertaMallaCurricular()
            ));
            
            if(!$existe){
                $servicios = new DocenteServicio();                
                $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
                $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(3));
                $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));        

                $em = $this->getDoctrine()->getManager();
                $em->persist($servicios);
                $em->flush();

                $ea->setIdDocenteServicio($servicios);
                $ea->setIdGradoAcademico($this->getDoctrine()->getRepository('AppBundle:GradoAcademico')->findOneById(1));
                $ea->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());

                $em->persist($ea);
                $em->flush();


                $this->addFlash('notice', 'Solicitud Creada Correctamente, en lo que la solicitud sea aprobada, se le notificará por correo.');
            }else{
                $this->addFlash('warning', 'Solicitud ya existente');
            }
            
            
        }
        
        
        
       $ea = $this->getDoctrine()->getRepository('AppBundle:EstadoAcademico')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
       $oferta = $this->getDoctrine()->getRepository('AppBundle:OfertaMallaCurricular')->findBy(array(
          'idMallaCurricularInstitucion' => $this->getUser()->getIdRolInstitucion()->getIdInstitucion() 
       ));
        
       return $this->render('solicitudes/estado_academico.html.twig', array(
           'estado_academico'   => $ea,
           'oferta'             => $oferta,
           'form'  =>  $form->createView()
       ));        
        
        
        
    }
    
    
   /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/estado_academico/{id}", name="cea_estado_academico_show")
     * @Method("GET")
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function solicitudesEstadoAcademicoShowAction(DocenteServicio $servicio)
    {        
        $ea = $this->getDoctrine()->getRepository('AppBundle:EstadoAcademico')->findOneByIdDocenteServicio($servicio);
        
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());

        return $this->render('cea/servicios_mostar.html.twig', array(
            'estado_academico' => $ea, 
            'servicio'  => $servicio,            
        ));
    }
    
    
    /**
     * 
     *
     * @Route("/mis_servicios/estado_academico/imprimir/{id}", name="servicio_estado_academico_imprimir")
     * @Method({"GET", "POST"})
     */
    public function serviciosEstadoAcademicoImprimirAction(DocenteServicio $estado_academico){
        
       
       
       if($estado_academico->getIdEstatus()->getId() == 1){
         $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($estado_academico->getIdRolInstitucion());
         $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneByIdRolInstitucion($estado_academico->getIdRolInstitucion());
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
            
            $correlativo = $this->getDoctrine()->getRepository('AppBundle:Memorando')->findOneByIdDocenteServicio($estado_academico->getId());
            
            if(!$correlativo){
                    $correlativo = $this->getDoctrine()->getRepository('AppBundle:Memorando')->findOneBy(
                         array('ano'=> date("Y")), 
                        array('id' => 'DESC')
                    );
                    $numero = 1;
                    if ($correlativo) $numero = $correlativo->getCorrelativo() + 1;

                    $memo = new Memorando();
                    $memo->setCorrelativo($numero);
                    $memo->setIdDocenteServicio($estado_academico);
                    $memo->setAno(date("Y"));
                    $memo->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(1));

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($memo);
                    $em->flush();
                    $memorando = $memo->getCorrelativo() . "-" . $memo->getAno();
            }else{
                $memorando = $correlativo->getCorrelativo() . "-" . $correlativo->getAno();
            }
     
            return $this->render('memorando/estado_academico.html.twig', array(
                'estado_academico'    =>  $estado_academico,
                'adscripcion'   =>  $adscripcion,
                'escala'        =>  $escala,
                'diferencia'    =>  $recon,
                'correlativo'   =>  $memorando
            ));
        
        
       }else{
           
           $this->addFlash('danger', 'No Puede Imprimir el reconocimiento de EstadoAcademico hasta que esté aprobado por el coordinador del CEA.');
       
        $servicios = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        
        
        return $this->render('solicitudes/index.html.twig', array(
            'servicios' => $servicios,
            'adscripcion' => $adscripcion
        ));
           
       }
        
        
        
    }
    
    
    
    
     
    //put your code here
}
