<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;
use AppBundle\Entity\DocentePermisoTiempo;
use AppBundle\Entity\DocumentosVerificados;
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
       $servicioAdscripcion = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->
                findOneBy(array(
                    'idRolInstitucion'  =>  $this->getUser()->getIdRolInstitucion()->getId(),
                    'idServicioCe'      =>  2
        ));
              
       
       $ascenso = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->
                findOneBy(array(
                    'idRolInstitucion'  =>  $this->getUser()->getIdRolInstitucion()->getId(),
                    'idServicioCe'      =>  5),
                    array('id' => 'DESC') 
        );
       
       //si no ha solicitado adscripción regresa a la pagina de adscripcion
        if(!$servicioAdscripcion){ return $this->redirect($this->generateUrl('solicitud_adscripcion')); }



        $pida = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->
        findOneBy(array(
            'idRolInstitucion'  =>  $this->getUser()->getIdRolInstitucion()->getId(),
            'idServicioCe'      =>  4),
            array('id' => 'DESC')
        );
        $em = $this->getDoctrine()->getManager();
        if(!$pida){
            $this->addFlash('warning', 'Estimado Docente Mientras se verifica su adscripción, le solicitamos que por favor cree su PIDA.');
            return $this->redirectToRoute('solicitud_pida');
        }else{
            $caducidad = $this->getDoctrine()->getRepository("AppBundle:PidaCaducidad")->findOneByIdDocenteServicio($pida);
            if($caducidad){
                //saber si el pida actual caducó
                $hoy = new \DateTime("now");

                $tiempo = ($hoy->diff($caducidad->getFechaFinal()));
                $vigente = $tiempo->invert ? false : true;
                if($tiempo->format('%a%') <= 60 && $tiempo->format('%a%') >= 30){
                    $suffix = ( $tiempo->invert ? ' venció hace' : 'estará viegene por' );
                    $this->addFlash('warning', 'Estimado docente su PIDA '  . $suffix . $tiempo->format('%a%') . ' días más' );
                }else if($tiempo->format('%a%') <= 29  && $vigente){
                    $this->addFlash('danger', 'Estimado docente dentro de '  . $tiempo->format('%a%') . ' días su PIDA caducará y deberá crear uno nuevo');
                }
                //var_dump($tiempo); die;
                $vencido = ($tiempo->invert ? true : false);
                if($vencido){
                    $pida->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(5));
                    $em->persist($pida);
                    $em->flush();
                    $this->addFlash('danger', 'Su pida Actual venció, por favor registre un nuevo PIDA.');
                    return $this->redirect($this->generateUrl('solicitud_pida'));

                }
            }

        }

        $adscripcionPida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->
                findBy(array(
                    'idRolInstitucion'  =>  $this->getUser()->getIdRolInstitucion()->getId()                    
        ));
               
        

        
         $escalafon = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion()),
                array('id' => 'DESC')
         );

         $tiempoTranscurrido = 0;
         $suffix = "";

         if ($escalafon && $escalafon->getidEscala()->getId() != 5){
             $escalafones = $this->getDoctrine()->getRepository("AppBundle:Escalafones")->findOneById($escalafon->getIdEscala()->getId() + 1); //tiempo para el proximo escalafon
             if($escalafones){
                 //tiempo para el prox escalafon
                 $tiempoProxEscalafon = $escalafon->getFechaEscala()->modify('+' . $escalafones->getTiempo() . 'years');                 
                 $hoy = new \DateTime("now");
                 $tiempoTranscurrido = $hoy->diff($tiempoProxEscalafon);
                 $suffix = ( $tiempoTranscurrido->invert ? ' ago' : '' );                 
             }
         }
        
        
        
        $adscripcion = $this->getDoctrine()->getRepository("AppBundle:Adscripcion")->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion()->getId());
        //solicitud aprobada está en falso
        $adscrito = false;
        if($servicioAdscripcion->getIdEstatus()->getId() == 1){ $adscrito = true; }
        
        return $this->render('cea/index.html.twig', array (
            'adscrito' => $adscrito,
            'adscripcion'   => $adscripcion,
            'ascenso'   => $ascenso,
            'tiempoProxEscalafon'   => $tiempoTranscurrido,
            'suffix'                => $suffix
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
        $em = $this->getDoctrine()->getManager();
        $docente = $em->getRepository("AppBundle:RolInstitucion")->findOneById($servicio->getIdRolInstitucion()->getId());
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(array(
                'idRolInstitucion' => $servicio->getIdRolInstitucion(),
                 'idTipoEscala'   => 1
        ));        
        return $this->render('cea/servicios_mostar.html.twig', array(
            'servicio' => $servicio,
            'oposicion' => $escala,
            'adscripcion' => $adscripcion,
            'docente'   => $docente
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
    public function serviciosEditAction(DocenteServicio $servicios, $estatus, Request $request)
    {              
       $em = $this->getDoctrine()->getManager();
       $mensaje = "";              
       if($estatus == "true") {
           $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));           
           
           if($servicios->getIdServicioCe()->getId() == '3'){
                $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
                $user->addRol($this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName("ROLE_ESTUDIANTE"));
                $em->persist($user); 
           }

           $parametros = $request->request->all();


           //Guardar el resultado de la verificación de Documentos de los permisos sabaticos
           if($servicios->getIdServicioCe()->getId() == 8){
                   verificar_documentos4($servicios->getIdRolInstitucion(), 18, 1, $em, "", $servicios);
           }

           if($servicios->getIdServicioCe()->getId() == 9){
               verificar_documentos4($servicios->getIdRolInstitucion(), 19, 1, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 20, 1, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 21, 1, $em, "", $servicios);
           }

           if($servicios->getIdServicioCe()->getId() == 10){
               verificar_documentos4($servicios->getIdRolInstitucion(), 19, 1, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 20, 1, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 22, 1, $em, "", $servicios);

           }

           
                                            
       }else{
           $mensaje = $request->request->get('message-text');
           $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));           
           if($servicios->getIdServicioCe()->getId() == '3'){
                $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
                $user->removeRol($this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName("ROLE_ESTUDIANTE"));
                $em->persist($user); 
           }

           //Guardar el resultado de la verificación de Documentos de los permisos sabaticos
           if($servicios->getIdServicioCe()->getId() == 8){
               verificar_documentos4($servicios->getIdRolInstitucion(), 18, 3, $em, "", $servicios);
           }

           if($servicios->getIdServicioCe()->getId() == 9){
               verificar_documentos4($servicios->getIdRolInstitucion(), 19, 3, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 20, 3, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 21, 3, $em, "", $servicios);
           }

           if($servicios->getIdServicioCe()->getId() == 10){
               verificar_documentos4($servicios->getIdRolInstitucion(), 19, 3, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 20, 3, $em, "", $servicios);
               verificar_documentos4($servicios->getIdRolInstitucion(), 22, 3, $em, "", $servicios);
           }
       }
                  
       $em->persist($servicios);       
       $em->flush();
       
       $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
       
       /*$message = \Swift_Message::newInstance()
                    ->setSubject('Resultado Solicitud de Servicio Docente CEA@UBV')
                    ->setFrom('wilmer.ramones@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'correos/actualizar_servicio.html.twig',
                            array(    
                                'nombres'   => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerNombre(),
                                'apellidos' => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerApellido(),
                                'servicio'  => $servicios,
                                'mensaje'   => $mensaje,
                            )
                        ),
                        'text/html'
                    )                    
                ;
                $this->get('mailer')->send($message);*/
       
       $this->addFlash('notice', 'Servicio Actualizada Correctamente, hemos enviado un correo al docente notificandole los cambios.');
       
       $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(array(
                'idRolInstitucion' => $servicios->getIdRolInstitucion(),
                 'idTipoEscala'   => 1
        ));
       
       $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicios->getIdRolInstitucion());
       $ea = $this->getDoctrine()->getRepository('AppBundle:EstadoAcademico')->findOneByIdDocenteServicio($servicios);
        return $this->render('cea/servicios_mostar.html.twig', array(
            'servicio' => $servicios,
            'docente'   => $servicios->getIdRolInstitucion(),
            'oposicion' => $escala,
            'adscripcion' => $adscripcion,
            'estado_academico' => $ea            
        ));
       
    }
        

    
}

function verificar_documentos4($idRolInstitucion, $tipo, $estatus, $em, $ubicacion="", $servicio){
    $existe = $em->getRepository("AppBundle:DocumentosVerificados")->findOneBy(
        array('idRolInstitucion' => $idRolInstitucion,  'idTipoDocumentos'  => $tipo),
        array('id' => 'DESC')
    );


    if(!$existe) {
        $verificacion = new DocumentosVerificados();
        $verificacion->setIdEstatus($em->getRepository("AppBundle:Estatus")->findOneById($estatus));
        $verificacion->setIdRolInstitucion($idRolInstitucion);
        $verificacion->setIdServicio($servicio);
        $verificacion->setIdTipoDocumentos($em->getRepository("AppBundle:TipoDocumentos")->findOneById($tipo));
        $verificacion->setUbicacion($ubicacion);
        $em->persist($verificacion);
        $em->flush();
    }else{
        $existe->setIdEstatus($em->getRepository("AppBundle:Estatus")->findOneById($estatus));
        $em->persist($existe);
        $em->flush();
    }

}


