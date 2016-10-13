<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Adscripcion;
use AppBundle\Entity\DocenteServicio;


/**
 * Description of DocenteController
 *
 * @author ubv-cipee
 *
 * @Route("/ceapp")
 * 
 */
 
class AppController extends Controller {

    /**
     * Pagina principal de inicio de la session Docente.
     *
     * @Route("/", name="cea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        //verificar en las solicitudes la adscripcion del docente
       $adscripcion = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->
                findOneBy(array(
                    'idRolInstitucion'  =>  $this->getUser()->getIdRolInstitucion()->getId(),
                    'idServicioCe'      =>  2
        ));
       //si no ha solicitado adscripción regresa a la pagina de adscripcion
        if(!$adscripcion){ return $this->redirect($this->generateUrl('solicitud_adscripcion')); }
        
        $pida = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->
                findOneBy(array(
                    'idRolInstitucion'  =>  $this->getUser()->getIdRolInstitucion()->getId(),
                    'idServicioCe'      =>  4
        ));
        
        if(!$pida){ return $this->redirect($this->generateUrl('solicitud_pida')); }
        
        
        //solicitud aprobada está en falso
        $adscrito = false;
        if($adscripcion->getIdEstatus()->getId() == 1) $adscrito = true;
        
        return $this->render('cea/index.html.twig', array (
            'adscrito' => $adscrito
        ));
    }
    
    
    
     
    /**
     * Muestra la página Puede ver los estatus de las solicitudes realizadas
     * y permite realizar la solicitud
     *
     * @Route("/servicios/{tipo}/{estatus}", name="cea_servicios")
     * @Method({"GET", "POST"})
     */
    public function verServiciosAction(Request $request, $tipo="antiguedad", $estatus=2){
        
        if ($tipo == "antiguedad") $tipo_servicio = 1;
         if ($request->getMethod() != 'POST') {
            $servicios = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findBy(array(
                                'idEstatus'     => $estatus,
                    ));
            switch ($estatus){
                case 1: 
                    $mensaje = "activas";
                    break;
                case 2: 
                    $mensaje = "en espera";
                    break;
                case 3:
                    $mensaje = "rechazadas";
                    break;
            }
        }else{
            
            $persona = $this->getDoctrine()->getRepository('AppBundle:Persona')
                              ->findOneByCedulaPasaporte($request->get('docente'));
            
             if (!$persona) {
                $this->addFlash('danger', 'Docente ' . $request->get('docente') . ' no Registrado en la Base de Datos del Centro de Estudios.');
               return $this->render('cea/index.html.twig', array (
                    'adscrito' => true
                ));
            }
            
            //1. obtener el rol-institucion-persona
            $rol = $this->getDoctrine()->getRepository(
                'AppBundle:RolInstitucion')->findOneByIdRol(
                    $this->getDoctrine()->getRepository(
                        'AppBundle:Rol')->findOneByIdPersona($persona));

            //si no existe el rol del docente, enviar correo al encargado de la región para verificar.
            if (!$rol) {
                $this->addFlash('danger', 'Docente no Registrado en la Base de Datos del Centro de Estudios.  Por Favor');
                 return $this->render('cea/index.html.twig');
            }
            
            
            $servicios = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findByIdRolInstitucion($rol->getId());
            $mensaje = "Busqueda : " . $request->get('docente');
        }
        return $this->render('cea/servicios.html.twig', array(
            'servicios'          => $servicios,
            'estatus_servicio'   => $mensaje,
            'tipo'               => $tipo
        ));
                                
        
    }
    
    
    /**
     * Encuentra y muestra una entidad de tipo Servicios Docente.
     *
     * @Route("/ver_servicio/{id}", name="cea_servicio_show")
     * @Method("GET")
     */
    public function serviciosShowAction(DocenteServicio $servicio)
    {        
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(array(
                'idRolInstitucion' => $servicio->getIdRolInstitucion(),
                 'idTipoEscala'   => 1
        ));        
        return $this->render('cea/servicios_mostar.html.twig', array(
            'servicio' => $servicio,
            'oposicion' => $escala,
            'adscripcion' => $adscripcion
        ));
    }
    
    
    /**
     * Muestra la página donde explica brevemente el reconocimiento de Antiguedad
     * y permite realizar la solicitud
     *
     * @Route("/mis_servicios/", name="servicios_index")
     * @Method({"GET", "POST"})
     */
    public function serviciosIndexAction(){
        
        $servicios = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        
        
        return $this->render('solicitudes/index.html.twig', array(
            'servicios' => $servicios,
            'adscripcion' => $adscripcion
        ));
    }
    
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/servicios/actualizar/{id}/{estatus}", name="cea_servicios_actualizar")
     * @Method({"GET", "POST"})
     */
    public function serviciosEditAction(DocenteServicio $servicios, $estatus)
    {
               
       $em = $this->getDoctrine()->getManager();
       if($estatus == "true") {
           $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));           
           
           if($servicios->getIdServicioCe()->getId() == '3'){
                $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
                $user->addRol($this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName("ROLE_ESTUDIANTE"));
                $em->persist($user); 
           }
           
                                            
       }else{
           $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));           
           if($servicios->getIdServicioCe()->getId() == '3'){
                $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
                $user->removeRol($this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName("ROLE_ESTUDIANTE"));
                $em->persist($user); 
           }
       }
                  
       $em->persist($servicios);       
       $em->flush();
       
       $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
       
       $message = \Swift_Message::newInstance()
                    ->setSubject('Resultado Solicitud de Servicio Docente CEA@UBV')
                    ->setFrom('wilmer.ramones@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'correos/actualizar_servicio.html.twig',
                            array(    
                                'nombres'   => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerNombre(),
                                'apellidos' => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerApellido(),
                                'servicio'  => $servicios
                            )
                        ),
                        'text/html'
                    )                    
                ;
                $this->get('mailer')->send($message);
       
       $this->addFlash('notice', 'Servicio Actualizada Correctamente, hemos enviado un correo al docente notificandole los cambios.');
       
       $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(array(
                'idRolInstitucion' => $servicios->getIdRolInstitucion(),
                 'idTipoEscala'   => 1
        ));
       
       $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
       $ea = $this->getDoctrine()->getRepository('AppBundle:EstadoAcademico')->findOneByIdDocenteServicio($servicios);
        return $this->render('cea/servicios_mostar.html.twig', array(
            'servicio' => $servicios,
            'oposicion' => $escala,
            'adscripcion' => $adscripcion,
            'estado_academico' => $ea            
        ));
       
    }
        
    
   
    
    
    
}
 