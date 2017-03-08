<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 09:08 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\DocumentosVerificados;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Adscripcion;
use AppBundle\Entity\DocenteEscala;
use AppBundle\Entity\Memorando;
use AppBundle\Entity\DocenteServicio;
use AppBundle\Entity\AdscripcionPida;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdscripcionController extends Controller
{
    /**
     * @Route("/solicitud/adscripcion", name="solicitud_adscripcion")
     */
    public function registerAction(Request $request)
    {
        //si ya se adscribió redirigirlo a la página principal del sistema
        if($this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion()->getId())){
            return $this->redirect($this->generateUrl('cea_index'));
        }

        $em = $this->getDoctrine()->getManager();
	    $adscripcion = new Adscripcion();
	    $escala = new DocenteEscala();


        /** @var TYPE_NAME $form */
        $form = $this->createForm('AppBundle\Form\UserType');
	    $form->handleRequest($request);


        //valida el formulario de los campos que son no requeridos pero se vuelven
        //requeridos al tildar el checkbox.
        if ($form->isSubmitted()) {
            if ($form->get('oposicion')->getData()) {
                //var_dump($form);
                if (!$form->get('fecha_oposicion')->getData()) {
                    $form->get('fecha_oposicion')->addError(new FormError('Fecha no puede estar en blanco'));
                }

                if (!$form->get('escala')->getData()) {
                    $form->get('escala')->addError(new FormError('Si selecciona que tiene concurso de oposción, debe seleccionar a que escalafón lo aprobó'));
                }

                if (!$form->get('documento_oposicion')->getData()) {
                    $form->get('documento_oposicion')->addError(new FormError('Si selecciona que tiene concurso de oposción, debe subir el digital de la aprobación del concurso'));
                }
            }


            if ( ($form->get('ascenso')->getData()) ) {
                //var_dump($form->get('escala')->getData()->getId()); exit;
                if($form->get('escala')->getData()->getId() == 1) {

                    if (!$form->get('fecha_ascenso_asistente')->getData()) {
                        $form->get('fecha_ascenso_asistente')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_asistente')->getData()) {
                        $form->get('documento_asistente')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }

                }

                if($form->get('escala')->getData()->getId() == 2) {

                    if (!$form->get('fecha_ascenso_agregado')->getData()) {
                        $form->get('fecha_ascenso_agregado')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_agregado')->getData()) {
                        $form->get('documento_agregado')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }

                if($form->get('escala')->getData()->getId() == 3) {

                    if (!$form->get('fecha_ascenso_asociado')->getData()) {
                        $form->get('fecha_ascenso_asociado')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_asociado')->getData()) {
                        $form->get('documento_asociado')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }


                if($form->get('escala')->getData()->getId() == 4) {

                    if (!$form->get('fecha_ascenso_titular')->getData()) {
                        $form->get('fecha_ascenso_titular')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_titular')->getData()) {
                        $form->get('documento_titular')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }


            }



            if ( ($form->get('ascenso2')->getData()) ) {
                //var_dump($form->get('escala')->getData()->getId()); exit;
                if($form->get('escala')->getData()->getId() == 1) {

                    if (!$form->get('fecha_ascenso_agregado')->getData()) {
                        $form->get('fecha_ascenso_agregado')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_agregado')->getData()) {
                        $form->get('documento_agregado')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }

                if($form->get('escala')->getData()->getId() == 2) {

                    if (!$form->get('fecha_ascenso_asociado')->getData()) {
                        $form->get('fecha_ascenso_asociado')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_asociado')->getData()) {
                        $form->get('documento_asociado')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }

                if($form->get('escala')->getData()->getId() == 3) {

                    if (!$form->get('fecha_ascenso_titular')->getData()) {
                        $form->get('fecha_ascenso_titular')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_titular')->getData()) {
                        $form->get('documento_titular')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }


            }


            if ( ($form->get('ascenso3')->getData()) ) {
                //var_dump($form->get('escala')->getData()->getId()); exit;
                if($form->get('escala')->getData()->getId() == 1) {

                    if (!$form->get('fecha_ascenso_asociado')->getData()) {
                        $form->get('fecha_ascenso_asociado')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_asociado')->getData()) {
                        $form->get('documento_asociado')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }

                if (($form->get('escala')->getData()->getId() == 2)  && ($form->get('ascenso2')->getData() == false )) {

                    if (!$form->get('fecha_ascenso_asociado')->getData()) {
                        $form->get('fecha_ascenso_asociado')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_asociado')->getData()) {
                        $form->get('documento_asociado')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }else if ($form->get('escala')->getData()->getId() == 2) {

                    if (!$form->get('fecha_ascenso_titular')->getData()) {
                        $form->get('fecha_ascenso_titular')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_titular')->getData()) {
                        $form->get('documento_titular')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }


            }


            if ( ($form->get('ascenso4')->getData()) ) {

                if($form->get('escala')->getData()->getId() == 1) {

                    if (!$form->get('fecha_ascenso_asociado')->getData()) {
                        $form->get('fecha_ascenso_asociado')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_asociado')->getData()) {
                        $form->get('documento_asociado')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }

                if($form->get('escala')->getData()->getId() == 2) {

                    if (!$form->get('fecha_ascenso_titular')->getData()) {
                        $form->get('fecha_ascenso_titular')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_titular')->getData()) {
                        $form->get('documento_titular')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }

                if($form->get('escala')->getData()->getId() == 3) {

                    if (!$form->get('fecha_ascenso_titular')->getData()) {
                        $form->get('fecha_ascenso_titular')->addError(new FormError('Fecha no puede estar en blanco'));
                    }

                    if (!$form->get('documento_titular')->getData()) {
                        $form->get('documento_titular')->addError(new FormError('Si tildó este ascendo, documento de aprobación de ascenso no puede estar en blanco'));
                    }
                }

            }


        }

        if ($form->isSubmitted() && $form->isValid()) {
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(2));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));

            $em->persist($servicios);


            $em->flush(); //guarda en la base de datos

        	  //var_dump($form->get('lineas_investigacion')->getData()); exit;

		 // $file stores the uploaded PDF file
            /** @var UploadedFile $constanciaTrabajo */
            $constanciaTrabajo = $form->get('trabajo')->getData();
            /** @var UploadedFile $constanciaPregrado */
            $constanciaPregrado = $form->get('pregrado')->getData();
            

            // Generate a unique name for the file before saving it
            $nombreTrabajo = md5(uniqid()).'.'.$constanciaTrabajo->guessExtension();
            

            // Move the file to the directory where brochures are stored
            $constanciaTrabajo->move(
                $this->container->getParameter('adscripcion_directory'),
                $nombreTrabajo
            );            
            thumbnail($nombreTrabajo, $this->container->getParameter('adscripcion_directory'), $this->container->getParameter('adscripcion_thumb_directory'));
             
            $nombrePregrado = md5(uniqid()).'.'.$constanciaPregrado->guessExtension();
             $constanciaPregrado->move(
                $this->container->getParameter('adscripcion_directory'),
                $nombrePregrado
            );
            thumbnail($nombrePregrado, $this->container->getParameter('adscripcion_directory'), $this->container->getParameter('adscripcion_thumb_directory'));
            if($form->get('postgrado')->getData()) {
                /** @var UploadedFile $constanciaPostgrado */
            	$constanciaPostgrado = $form->get('postgrado')->getData();
            	$nombrePostgrado = md5(uniqid()).'.'.$constanciaPostgrado->guessExtension();
            	$constanciaPostgrado->move(
                	$this->container->getParameter('adscripcion_directory'),
                	$nombrePostgrado
            	);
                thumbnail($nombrePostgrado, $this->container->getParameter('adscripcion_directory'), $this->container->getParameter('adscripcion_thumb_directory'));
                verificar_documentos($this->getUser()->getIdRolInstitucion(), 3, 2, $em, $nombrePostgrado, $servicios);
            }



            $adscripcion->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $adscripcion->setFechaIngreso($form->get('fecha_ingreso')->getData());
            $adscripcion->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(2));
            $adscripcion->setIdLineaInvestigacion($form->get('lineas_investigacion')->getData());
            $adscripcion->setTituloTrabajo($form->get('titulo_trabajo')->getData());
            verificar_documentos($this->getUser()->getIdRolInstitucion(), 1, 2, $em, $nombreTrabajo, $servicios);
            verificar_documentos($this->getUser()->getIdRolInstitucion(), 2, 2, $em, $nombrePregrado, $servicios);
            
            $correlativo = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneBy(
                   array(), 
                   array('correlativoAdscripcion' => 'DESC')
            );
            $numero = 1;
            $ano = date("Y");
            if ($correlativo){
                $numero = $correlativo->getCorrelativoAdscripcion() + 1;                                      
            }
            $adscripcion->setAnoAdscripcion($ano);
            $adscripcion->setCorrelativoAdscripcion($numero);

            if ($form->get('oposicion')->getData()){
                $escala->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
                $escala->setFechaEscala($form->get('fecha_oposicion')->getData());
                $escala->setIdEscala($form->get('escala')->getData());
                $escala->setIdTipoEscala($this->getDoctrine()->getRepository('AppBundle:TipoAscenso')->findOneById(1));
                $em->persist($escala);

                if($form->get('documento_oposicion')->getData()) {
                    $constanciaOposicion = $form->get('documento_oposicion')->getData();
                    $nombreOposicion = md5(uniqid()).'.'.$constanciaOposicion->guessExtension();
                    $constanciaOposicion->move(
                        $this->container->getParameter('adscripcion_directory'),
                        $nombreOposicion
                    );
                    thumbnail($nombreOposicion, $this->container->getParameter('adscripcion_directory'), $this->container->getParameter('adscripcion_thumb_directory'));
                    verificar_documentos($this->getUser()->getIdRolInstitucion(), 4, 2, $em, $nombreOposicion, $servicios);
                }




                if ($form->get('documento_asistente')->getData()) {
                    $escala2 = new DocenteEscala();
                    $asistente = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById(2);
                    $escala2->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
                    $escala2->setFechaEscala($form->get('fecha_ascenso_asistente')->getData());
                    $escala2->setIdEscala($asistente);
                    $escala2->setIdTipoEscala($this->getDoctrine()->getRepository('AppBundle:TipoAscenso')->findOneById(2));
                    $em->persist($escala2);
                    verificar_documentos($this->getUser()->getIdRolInstitucion()->getId(), 5, 2, $em, $servicios);

                    $constanciaAsistente = $form->get('documento_asistente')->getData();
                    $nombreAsistente = md5(uniqid()).'.'.$constanciaAsistente->guessExtension();
                    $constanciaAsistente->move(
                        $this->container->getParameter('ascenso_directory'),
                        $nombreAsistente
                    );
                    thumbnail($nombreAsistente, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                    verificar_documentos($this->getUser()->getIdRolInstitucion(), 5, 2, $em, $nombreAsistente, $servicios);


                }

               if ($form->get('documento_asociado')->getData()) {
                    $escala3 = new DocenteEscala();
                    $asociado = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById(3);
                    $escala3->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
                    $escala3->setFechaEscala($form->get('fecha_ascenso_asociado')->getData());
                    $escala3->setIdEscala($asociado);
                    $escala3->setIdTipoEscala($this->getDoctrine()->getRepository('AppBundle:TipoAscenso')->findOneById(2));
                    $em->persist($escala3);


                   $constanciaAsociado = $form->get('documento_asociado')->getData();
                   $nombreAsociado = md5(uniqid()).'.'.$constanciaAsociado->guessExtension();
                   $constanciaAsociado->move(
                       $this->container->getParameter('ascenso_directory'),
                       $nombreAsociado
                   );
                   thumbnail($nombreAsociado, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                   verificar_documentos($this->getUser()->getIdRolInstitucion(), 6, 2, $em, $nombreAsociado, $servicios);
                }


                if ($form->get('documento_agregado')->getData()) {
                    $escala4 = new DocenteEscala();
                    $agregado = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById(4);
                    $escala4->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
                    $escala4->setFechaEscala($form->get('fecha_ascenso_agregado')->getData());
                    $escala4->setIdEscala($agregado);
                    $escala4->setIdTipoEscala($this->getDoctrine()->getRepository('AppBundle:TipoAscenso')->findOneById(2));
                    $em->persist($escala4);

                    $constanciaAgregado = $form->get('documento_agregado')->getData();
                    $nombreAgregado = md5(uniqid()).'.'.$constanciaAgregado->guessExtension();
                    $constanciaAgregado->move(
                        $this->container->getParameter('ascenso_directory'),
                        $nombreAgregado
                    );
                    thumbnail($nombreAgregado, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                    verificar_documentos($this->getUser()->getIdRolInstitucion(), 7, 2, $em, $nombreAgregado, $servicios);
                }


                if ($form->get('documento_titular')->getData()) {
                    $escala5 = new DocenteEscala();
                    $titular = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById(5);
                    $escala5->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
                    $escala5->setFechaEscala($form->get('fecha_ascenso_titular')->getData());
                    $escala5->setIdEscala($titular);
                    $escala5->setIdTipoEscala($this->getDoctrine()->getRepository('AppBundle:TipoAscenso')->findOneById(2));
                    $em->persist($escala5);
                    verificar_documentos($this->getUser()->getIdRolInstitucion()->getId(), 8, 2, $em, $servicios);

                    $constanciaTitular = $form->get('documento_titular')->getData();
                    $nombreTitular = md5(uniqid()).'.'.$constanciaTitular->guessExtension();
                    $constanciaTitular->move(
                        $this->container->getParameter('ascenso_directory'),
                        $nombreTitular
                    );
                    thumbnail($nombreTitular, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                    verificar_documentos($this->getUser()->getIdRolInstitucion(), 8, 2, $em, $nombreTitular, $servicios);
                }

            }





            $em->persist($adscripcion);
            $em->flush();
            return $this->redirect($this->generateUrl('cea_index'));	
        }

        return $this->render(
            'solicitudes/adscripcion.html.twig',
            array('form' => $form->createView())
        );
    }
    
    
    /**
     * Solicita información al docente sobre su PIDA
     * 
     * @Route("/solicitud/pida", name="solicitud_pida")
     * @Method({"GET", "POST"})
     */
    public function pidaAction(Request $request)
    {
        
         //verificar en las solicitudes la adscripcion del docente
       $adscripcion = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->
                findOneBy(array(
                    'idRolInstitucion'  =>  $this->getUser()->getIdRolInstitucion()->getId(),
                    'idServicioCe'      =>  2
        ));
       //si no ha solicitado adscripción regresa a la pagina de adscripcion
        if(!$adscripcion) return $this->redirect($this->generateUrl('solicitud_adscripcion'));
        
        //si ya se tiene PIDA
        if($this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion()->getId())){
            return $this->redirect($this->generateUrl('cea_index'));
        }
        
        $pida = new AdscripcionPida();
        $form = $this->createForm('AppBundle\Form\PidaType', $pida);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(4));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));

            
            
            $pida->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $pida->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(2));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($pida);
            $em->persist($servicios);
            $em->flush();
            
            return $this->redirectToRoute('cea_index');
        
        }
        
        
        return $this->render(
            'solicitudes/pida.html.twig',
            array('form' => $form->createView())
        );
        
        
    }
    
    
    /**
     * Muestra las Solicitudes de Adscripción.  Por defecto las creadas (estatus = 2)
     *
     * @Route("/solicitudes/adscripcion/{estatus}", name="cea_adscripciones")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function verSolicitudesAdscripcionAction($estatus = 2, Request $request)
    {
         $servicios = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findBy(array(
                'idEstatus' => $estatus,
                'idServicioCe' => 2
            ));  
        
        if ($request->getMethod() != 'POST') {
                     
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
            
            
            $adscripciones = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findByIdRolInstitucion($rol->getId());
            $mensaje = "Busqueda : " . $request->get('docente');
        }
        return $this->render('cea/servicios.html.twig', array(
            'servicios' => $servicios,
            'estatus_adscripciones' => $mensaje
        ));
    }
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/adscripcion/{id}", name="cea_adscripcion_show")
     * @Method("GET")
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function solicitudesAdscripcionShowAction(DocenteServicio $servicio)
    {        
        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository("AppBundle:RolInstitucion")->findOneById($servicio->getIdRolInstitucion());



        return $this->render('cea/solicitudes_mostar.html.twig', array(
            'servicio'  => $servicio,
            'servicio' => $servicio,
            'todo'      => $todo
        ));
    }
    
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/solicitudes/actualizar/{id}", name="cea_solicitudes_actualizar")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function solicitudesAdscripcionEditAction(Adscripcion $adscripcion, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $mensaje = "";
       $serviciosAdscripcion = $em->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
           'idRolInstitucion'   => $adscripcion->getIdRolInstitucion(),
           'idServicioCe'       => 2
       ));
       $parametros = $request->request->all();

        //Guardar el resultado de la verificación de Documentos
        foreach ($parametros as $key => $value){
            if($key === 'trabajo') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 1, $value, $em, "", $serviciosAdscripcion);
            }else if($key === 'pregrado') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 2, $value, $em, "", $serviciosAdscripcion);
            }else if($key === 'postgrado') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 3, $value, $em, "",  $serviciosAdscripcion);
            }else if($key === 'oposicion') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 4, $value, $em, "", $serviciosAdscripcion);
            }else if($key === 'asistente') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 5, $value, $em, "", $serviciosAdscripcion);
            }else if($key === 'agregado') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 6, $value, $em, "", $serviciosAdscripcion);
            }else if($key === 'asociado') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 7, $value, $em, "", $serviciosAdscripcion);
            }else if($key === 'titular') {
                verificar_documentos($adscripcion->getIdRolInstitucion(), 8, $value, $em, "", $serviciosAdscripcion);
            }
        }

       
       $serviciosPida = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
           'idRolInstitucion'   => $adscripcion->getIdRolInstitucion(),
           'idServicioCe'       => 4
       ));
       
       $pida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($adscripcion->getIdRolInstitucion());
       if(isset($parametros['aprobar'])) {
           $estatus = true;
       }else{
           $estatus = false;
       }
       if($estatus == "true") {
           $serviciosAdscripcion->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));
           $serviciosPida->setIdEstatus($serviciosAdscripcion->getIdEstatus());
           $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($adscripcion->getIdRolInstitucion());
           $user->addRol($this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName("ROLE_ADSCRITO"));
           $pida->setIdEstatus($serviciosAdscripcion->getIdEstatus());
                                            
       }else{
           $mensaje = $request->request->get('message-text');
           $serviciosAdscripcion->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));
           $serviciosPida->setIdEstatus($serviciosAdscripcion->getIdEstatus());
           $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($adscripcion->getIdRolInstitucion());
           $user->removeRol($this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName("ROLE_ADSCRITO"));
           $pida->setIdEstatus($serviciosAdscripcion->getIdEstatus());
       }
           
       $em = $this->getDoctrine()->getManager();
       $em->persist($serviciosAdscripcion);
       $em->persist($serviciosPida);
       $em->persist($user);
       $em->persist($pida);
       $em->flush();
       
       $message = \Swift_Message::newInstance()
                    ->setSubject('Resultado Adscripcion CEA@UBV')
                    ->setFrom('wilmer.ramones@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'correos/actualizar_adscripcion.html.twig',
                            array(
                                'nombres'   => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerNombre(),
                                'apellidos' => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerApellido(),
                                'estatus'   => $serviciosAdscripcion->getIdEstatus(),
                                'mensaje'   => $mensaje
                            )
                        ),
                        'text/html'
                    )                    
                ;
                $this->get('mailer')->send($message);
       
       $this->addFlash('notice', 'Solicitud Actualizada Correctamente, hemos enviado un correo al docente notificandole los cambios.');
       
       $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findBy(array(
            'idRolInstitucion' => $adscripcion->getIdRolInstitucion()->getId()
        ));

        return $this->redirect($this->generateUrl('cea_adscripcion_show', array('id' => $serviciosAdscripcion->getId())));
       
    }
    
    
     /**
     * Muestra la página donde explica brevemente el reconocimiento de Antiguedad
     * y permite realizar la solicitud
     *
     * @Route("/mis_servicios/adscripcion/imprimir/{id}", name="servicio_adscripcion_imprimir")
     * @Method({"GET", "POST"})
     */
    public function serviciosAdscripcionImprimirAction(DocenteServicio $servicio){
        
       
        if ($servicio->getIdEstatus()->getId() == 1){
            
            $correlativo = $this->getDoctrine()->getRepository('AppBundle:Memorando')->findOneByIdDocenteServicio($servicio);
            if(!$correlativo){
                 $correlativo = $this->getDoctrine()->getRepository('AppBundle:Memorando')->findOneBy(
                    array('ano'=> date("Y")), 
                   array('id' => 'DESC')
               );
               $numero = 1;
               if ($correlativo) $numero = $correlativo->getCorrelativo() + 1;
               $memo = new Memorando();
               $memo->setCorrelativo($numero);
               $memo->setIdDocenteServicio($servicio);
               $memo->setAno(date("Y"));
               $memo->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(1));

               $em = $this->getDoctrine()->getManager();
               $em->persist($memo);
               $em->flush();
               $memorando = $memo->getCorrelativo() . "-" . $memo->getAno();
            }else{
               $memorando = $correlativo->getCorrelativo() . "-" . $correlativo->getAno();
            }
                        
            $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
            $eje = $adscripcion->getIdRolInstitucion()->getIdInstitucion()->getIdEjeParroquia()->getIdEje()->getAbreviacion();
            return $this->render('memorando/adscripcion.html.twig', array(                
                'adscripcion'   =>  $adscripcion,                                
                'correlativo'   =>  $memorando,
                'eje'           =>  $eje
            ));
   
    }else{
        $this->addFlash('danger', 'No Puede Imprimir el reconocimiento de Adscripcion hasta que esté aprobado por el coordinador del CEA.');
       
        $servicios = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        
        
        return $this->render('solicitudes/index.html.twig', array(
            'servicios' => $servicios,
            'adscripcion' => $adscripcion
        ));
    }
    
    
    }  
}

/*funcion para crear miniaturas de las imagenes y carga más rapido la página */

function thumbnail ($filename, $fuente, $destino){   
     if(preg_match('/[.](jpeg)$/', $filename)) {
        $im = imagecreatefromjpeg($fuente . "/" . $filename);
    } else if (preg_match('/[.](jpg)$/', $filename)) {
        $im = imagecreatefromjpeg($fuente . "/" . $filename);
    }else if (preg_match('/[.](gif)$/', $filename)) {
        $im = imagecreatefromgif($fuente . "/" . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng($fuente . "/" . $filename);
    }

    $ox = imagesx($im);
    $oy = imagesy($im);

    $nx = 80;
    $ny = 80;

    $nm = imagecreatetruecolor($nx, $ny);

    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

    imagejpeg($nm, $destino . "/" . $filename);
}

function verificar_documentos($idRolInstitucion, $tipo, $estatus, $em, $ubicacion="", $servicio){
    $existe = $em->getRepository("AppBundle:DocumentosVerificados")->findOneBy(array(
        'idRolInstitucion' => $idRolInstitucion,
        'idTipoDocumentos'  => $tipo
    ));

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
