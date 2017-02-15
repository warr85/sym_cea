<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 09:08 AM
 */

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Ascenso;
use AppBundle\Entity\DocenteEscala;
use AppBundle\Entity\Memorando;
use AppBundle\Entity\DocenteServicio;
use AppBundle\Entity\AdscripcionPida;
use AppBundle\Entity\TutoresAscenso;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AscensoController extends Controller
{
    /**
     * @Route("/solicitud/ascenso", name="cea_solicitud_ascenso")
     */
    public function ascensoAction(Request $request)
    {
        $formalizarTiempo = false;
	//si ya tiene una solicitud en espera, enviarlo a la pagina de los  servicios
	$solicitud = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idServicioCe' => 5),
                array('id' => 'DESC')                
        );
        if($solicitud){
            if($solicitud->getIdEstatus()->getId() != 4 ){
                $this->addFlash('warning', 'Ya usted posee una solicitud de Ascenso en espera.  Puede consultar su estatus en el botón de "Mis servicios" ');
                return $this->redirect($this->generateUrl('servicios_index'));	
            }
        }
        
        
        //obtener su ultimo escalafon
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion()),
                array('id' => 'DESC')
        );
        
        if(!$escala){
            $this->addFlash('danger', 'Estimado Docente, todavia no ha concursado, debe concursar primero para poder realizar una solicitud de ascenso.');
                return $this->redirect($this->generateUrl('cea_index'));            
        }
        //busca la escala siguiente
        $escalafones = $this->getDoctrine()->getRepository("AppBundle:Escalafones")->findOneById($escala->getIdEscala()->getId() + 1); //tiempo para el proximo escalafon
        //si no hay escalas siguientes, es debido a que es titular
        if(!$escalafones){
            $this->addFlash('notice', 'Ya usted posee el máximo escalfón docente disponible. no puede solicitar este servicio.');
            return $this->redirect($this->generateUrl('servicios_index'));
        }
        
        $tiempoProxEscalafon = $escala->getFechaEscala()->diff(new \DateTime("now")); 
        
        //si no cumple el tiempo para solicitar ascenso
        if($tiempoProxEscalafon->y < $escalafones->getTiempo()){
            //preguntar si tiene activa una solicitud de antiguedad
            $servicioAntiguedad = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
                'idRolInstitucion' => $escala->getIdRolInstitucion(),
                'idServicioCe'  => 1,
                'idEstatus'     => 1
            ));
            
            //si tiene solicitud vamos a decirle al usuario que vamos a utlizarla para ver si le alcanza
            if($servicioAntiguedad){
                //obtenemos la fecha de concurso de oposición
                $oposicion = $this->getDoctrine()->getRepository("AppBundle:DocenteEscala")->findOneBy(array(
                    'idTipoEscala' => 1,
                    'idRolInstitucion' => $escala->getIdRolInstitucion()
                ));
                //obtenemos su fecha de ingreso
                $adscripcion = $this->getDoctrine()->getRepository("AppBundle:Adscripcion")->findOneByIdRolInstitucion($escala->getIdRolInstitucion());
                //calculamos su antiguedad
                $tiempoAntiguedad = $adscripcion->getFechaIngreso()->diff($oposicion->getFechaEscala());
                
                //calculamos el nuevo tiempo que tiene con el tiempo en años mas lo que se le debe
                $y = new \DateTime();
                $f = clone $y;
                $y->add($tiempoProxEscalafon);
                $y->add($tiempoAntiguedad);
                //tenemos el total de tiempo que tiene el docente
                $nuevoTiempo = $f->diff($y);
                
                //si todavía no cumple el tiempo
                if($nuevoTiempo->y < $escalafones->getTiempo()){
                    $this->addFlash('danger', 'Estimado Docente, Incluyendo la antiguedad que se le adeuda, Todavía no cumple el tiempo para solicitar el ascenso.');
                    return $this->redirect($this->generateUrl('cea_index'));   
                }else{
                    $formalizarTiempo = true;
                }
                    
                
             //si no tiene antiguedad   
            }else{
                 $this->addFlash('danger', 'Estimado Docente, Todavía no cumple el tiempo para solicitar el ascenso.');
                 return $this->redirect($this->generateUrl('cea_index'));   
            }
        }
        
        $siguiente = $escala->getIdEscala()->getId() + 1;
        $ascenso = new Ascenso();
        if($siguiente < 6){
            $nueva_escala = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById($siguiente);
        }else{
            $this->addFlash('notice', 'Ya usted posee el máximo escalfón docente disponible. no puede solicitar este servicio.');
            return $this->redirect($this->generateUrl('servicios_index'));
        }
        
        
        
        
        $tutoresAsignados = new TutoresAscenso();
        $form = $this->createForm('AppBundle\Form\AscensoType');
        $tutorForm = $this->createForm('AppBundle\Form\TutoresAscensoType', $tutoresAsignados);
	$form->handleRequest($request);
                	        

        if ($form->isSubmitted() && $form->isValid()) {       
            
            $ascenso = new Ascenso();
            // $file stores the uploaded PDF file
            /** @var UploadedFile $constanciaTrabajo */
            $constanciaTrabajo = $form->get('trabajo')->getData();
            /** @var UploadedFile $constanciaPregrado */
            $constanciaExpediente = $form->get('expediente')->getData();
            /** @var UploadedFile $constanciaPregrado */
            $constanciaPida = $form->get('pida')->getData();
            /** @var UploadedFile $constanciaPregrado */
            $constanciaNai = $form->get('nai')->getData();
            /** @var UploadedFile $constanciaPregrado */
            $constanciaInvestigacion = $form->get('investigacion')->getData();
            
            

            // Generate a unique name for the file before saving it
            $nombreTrabajo = md5(uniqid()).'.'.$constanciaTrabajo->guessExtension();
            $nombreExpediente = md5(uniqid()).'.'.$constanciaExpediente->guessExtension();
            $nombrePida = md5(uniqid()).'.'.$constanciaPida->guessExtension();
            $nombreNai = md5(uniqid()).'.'.$constanciaNai->guessExtension();
            $nombreInvestigacion = md5(uniqid()).'.'.$constanciaInvestigacion->guessExtension();

            // Guardar el archivo y crear la miniatura de cada uno
            $constanciaTrabajo->move(
                $this->container->getParameter('ascenso_directory'),
                $nombreTrabajo
            );             
            thumbnail2($nombreTrabajo, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
             
            
             $constanciaExpediente->move(
                $this->container->getParameter('ascenso_directory'),
                $nombreExpediente
            );
            thumbnail2($nombreExpediente, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            
            $constanciaPida->move(
                $this->container->getParameter('ascenso_directory'),
                $nombrePida
            );
            thumbnail2($nombrePida, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            
            
            $constanciaNai->move(
                $this->container->getParameter('ascenso_directory'),
                $nombreNai
            );
            thumbnail2($nombreNai, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            
            if($form->get('investigacion')->getData()) {
                /** @var UploadedFile $constanciaPostgrado */
            	$constanciaInvestigacion = $form->get('investigacion')->getData();
            	$nombreInvestigacion = md5(uniqid()).'.'.$constanciaInvestigacion->guessExtension();
            	$constanciaInvestigacion->move(
                	$this->container->getParameter('ascenso_directory'),
                	$nombreInvestigacion
            	);
                    thumbnail2($nombreInvestigacion, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                $ascenso->setInvestigacion($nombreInvestigacion);
            }
            $em = $this->getDoctrine()->getManager();

            $ascenso->setTrabajo($nombreTrabajo);
            $ascenso->setExpediente($nombreExpediente);            
            $ascenso->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $ascenso->setPida($nombrePida);
            $ascenso->setNai($nombreNai);
            $ascenso->setInvestigacion($nombreInvestigacion);
            $ascenso->setTituloTrabajo($form->get('titulo_trabajo')->getData());
            $ascenso->setTipoTrabajoInvestigacion($form->get('tipoTrabajoInvestigacion')->getData());
            $ascenso->setTesisUbv($form->get('tesisUbv')->getData());
            $ascenso->setNombreNucelo($form->get('nombreNucleo')->getData());
            $ascenso->setIdEscalafones($nueva_escala);
            $ascenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(2));
            
            
            $tutores = $form->get('tutores_ascenso')->getData();
            foreach ($tutores as $tutor){
                $ascenso->addTutoresAscenso($tutor);
            }
            
            
            if ($form->get('pertinencia')->getData()){
                
                $constanciaPertinencia = $form->get('pertinencia')->getData();
                $nombrePertinencia = md5(uniqid()).'.'.$constanciaPertinencia->guessExtension();
                $constanciaPertinencia->move(
                    $this->container->getParameter('ascenso_directory'),
                    $nombrePertinencia
                );
                thumbnail2($nombrePertinencia, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                $ascenso->setPertinencia($nombrePertinencia);
                //$ascenso->setIdLineaInvestigacion($form->get('lineas_investigacion')->getData());                                

            }
            
            
            if ($form->get('aprobacion')->getData()){
                
                $constanciaAprobacion = $form->get('aprobacion')->getData();
                $nombreAprobacion = md5(uniqid()).'.'.$constanciaAprobacion->guessExtension();
                $constanciaAprobacion->move(
                    $this->container->getParameter('ascenso_directory'),
                    $nombreAprobacion
                );
                thumbnail2($nombreAprobacion, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                $ascenso->setAprobacion($nombreAprobacion);
                //$ascenso->setIdLineaInvestigacion($form->get('lineas_investigacion')->getData());                                

            }
            
            
            if ($form->get('curriculo')->getData()){
                
                $constanciaCurriculo = $form->get('curriculo')->getData();
                $nombreCurriculo = md5(uniqid()).'.'.$constanciaCurriculo->guessExtension();
                $constanciaCurriculo->move(
                    $this->container->getParameter('ascenso_directory'),
                    $nombreCurriculo
                );
                thumbnail2($nombreCurriculo, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                $ascenso->setCurriculo($nombreCurriculo);
                //$ascenso->setIdLineaInvestigacion($form->get('lineas_investigacion')->getData());                                

            }


                
            
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(5));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));

            $em->persist($servicios);
            $em->persist($ascenso);
            //si realizó la solicitud usando la antiguedad, esta se formaliza
            if($formalizarTiempo){
                $servicioAntiguedad->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(4));
                $em->persist($servicioAntiguedad);
                $this->addFlash('warning', 'Su solicitud de Antiguedad ha quedado formalizada');
            }

            $em->flush(); //guarda en la base de datos
            

            
            $this->addFlash('success', 'Solicitud de Ascenso Registrada Satisfactoriamente');
            return $this->redirect($this->generateUrl('cea_index'));	
        }

        return $this->render(
            'solicitudes/ascenso.html.twig',
            array(
                'form' => $form->createView(),
                'tutorForm' => $tutorForm->createView(),
                'ultima_escala' => $escala,
                'nueva_escala'  => $nueva_escala,
                'antiguedad'    => $formalizarTiempo
            )
        );
    }
    
    
    
    
    
    /**
     * @Route("/solicitud/reconocimiento/escala", name="cea_solicitud_recocimiento_escala")
     */
    public function reconocimientoEscalaAction(Request $request)
    {
        

        //si ya tiene una solicitud en espera, enviarlo a la pagina de los  servicios
	$solicitud = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idServicioCe' => 5, 'idEstatus' => 1)                
        );
        
        
       
        
         $concurso = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneBy(
             array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion())                
         );
         
         
         $solicitudAscenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(
                array(
                    'idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(),
                    'idEstatus'         => 1
                )                
        );
         
         
	if (!$concurso->getOposicion()){
            $form = $this->createForm('AppBundle\Form\ReconocimientoConcursoType');
        }else{
            $form = $this->createForm('AppBundle\Form\ReconocimientoEscalaType');
        }
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {       
            
            
            $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $constanciaAscenso = $form->get('reconocimiento')->getData();
            
            $nombreAscenso = md5(uniqid()).'.'.$constanciaAscenso->guessExtension();

            // Guardar el archivo y crear la miniatura de cada uno
            if (!$concurso->getOposicion()){                
                $adscripcion->setOposicion($nombreAscenso);
                $adscripcion->setIdLineaInvestigacion($form['lineas_investigacion']->getData());
                $adscripcion->setTituloTrabajo($form['titulo_trabajo']->getData());
                $constanciaAscenso->move(
                    $this->container->getParameter('adscripcion_directory'),
                    $nombreAscenso
                );             
                thumbnail2($nombreAscenso, $this->container->getParameter('adscripcion_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            }else{
                $constanciaAscenso->move(
                    $this->container->getParameter('ascenso_directory'),
                    $nombreAscenso
                );             
                thumbnail2($nombreAscenso, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                switch ($solicitudAscenso->getIdEscalafones()->getId()){
                    case 2: $adscripcion->setAsistente($nombreAscenso);
                        break;
                    case 3: $adscripcion->setAgreado($nombreAscenso);
                        break;
                    case 4: $adscripcion->setAsociado($nombreAscenso);
                        break;
                    case 5: $adscripcion->setTitular($nombreAscenso);
                        break;
                    default:
                        break;
                }
            }
                      
            
            
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(6));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));
            $em = $this->getDoctrine()->getManager();
            $em->persist($servicios);
            $em->persist($adscripcion);
            
            $em->flush();
            $this->addFlash('success', 'Solicitud de Reconocimiento de escala Registrada Satisfactoriamente');
            return $this->redirect($this->generateUrl('cea_index'));		
        }
       
               
         if(!$concurso->getOposicion()){
              return $this->render(
                'solicitudes/reconocimientoEscala.html.twig',
                array(
                    'form' => $form->createView(), 
                    'tipo'  => 'Concurso de Oposición'
                )
            );
         } 
            
        
        
        if(!$solicitudAscenso){
            $this->addFlash('danger', 'Estimado Docente, No posee ninguna solicitud de Ascenso Activa.');
                return $this->redirect($this->generateUrl('cea_index'));            
        }
        
        
         
        
        
        
        return $this->render(
                'solicitudes/reconocimientoEscala.html.twig',
                array(
                    'form' => $form->createView(), 
                    'tipo'  => 'Ascenso ' . $solicitudAscenso->getIdEscalafones()->getNombre()
                )
            );
        
        

       

       
    }
    
    
    
     /**
     * Encuentra y muestra una entidad de tipo Ascenso.
     *
     * @Route("/ascenso/{id}", name="cea_ascenso_show")
     * @Method("GET")
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function solicitudesAscensoShowAction(DocenteServicio $servicio)
    {        
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion()->getId()
        ));
        
        $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion(),
            'idEstatus'         => 2
        ));
                
                
        $pida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        $antiguedad = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion(),
            'idServicioCe'  => 1            
        ));
        
         $form = $this->createForm('AppBundle\Form\AddTutorType');

        return $this->render('cea/ascenso_mostar.html.twig', array(
            'ascenso' => $ascenso, 
            'servicio'  => $servicio,
            'escalas' => $escala,            
            'pida'      => $pida,
            'antiguedad' => $antiguedad,
            'form' => $form->createView(), 
        ));
    }
    
    
    
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/reconocimientoEscala/{id}", name="cea_reconocimientoEscala_show")
     * @Method("GET")
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function reconocimientoEscalaShowAction(DocenteServicio $servicio)
    {        
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion()->getId()
        ));
        
        
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        
        $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
           'idRolInstitucion'   =>  $servicio->getIdRolInstitucion(),
            'idEstatus'         =>  1  
        ));
                
        $pida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        
        if($ascenso == NULL){
            $escalafones = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findAll();
        }else{
            $escalafones = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById($ascenso->getIdEscalafones()->getId());
        }
        
        
        
        return $this->render('cea/reconocimiento_escala_mostrar.html.twig', array(
            'ascenso' => $ascenso, 
            'adscripcion' => $adscripcion,
            'servicio'  => $servicio,
            'escalas' => $escala,            
            'pida'      => $pida,
            'escalafones' => $escalafones
            
        ));
    }
    
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/solicitudes/ascenso/{id}/{estatus}", name="cea_ascenso_actualizar")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function solicitudesAscensoEditAction(Ascenso $ascenso, $estatus, Request $request)
    {
        $mensaje = "";
       //$adscripciones = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneById($adscripcion->getId());
       $serviciosAscenso = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
           'idRolInstitucion'   => $ascenso->getIdRolInstitucion(),
           'idServicioCe'       => 5,
           'idEstatus'          => 2
       ));
       
       
              
       $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($ascenso->getIdRolInstitucion());
       if($estatus == "true") {
           $serviciosAscenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));                      
                                            
       }else{
           $mensaje = $request->request->get('message-text');
           $serviciosAscenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));           
       }
       
       $ascenso->setIdEstatus($serviciosAscenso->getIdEstatus());
           
       $em = $this->getDoctrine()->getManager();
       $em->persist($serviciosAscenso);       
       $em->persist($ascenso);
       $em->flush();
       
       $message = \Swift_Message::newInstance()
                    ->setSubject('Resultado Ascenso CEA@UBV')
                    ->setFrom('wilmer.ramones@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'correos/actualizar_ascenso.html.twig',
                            array(
                                'nombres'   => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerNombre(),
                                'apellidos'   => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerApellido(),
                                'estatus'   => $serviciosAscenso->getIdEstatus(),
                                'mensaje'   => $mensaje
                            )
                        ),
                        'text/html'
                    )                    
                ;
                $this->get('mailer')->send($message);
       
       $this->addFlash('notice', 'Solicitud Actualizada Correctamente, hemos enviado un correo al docente notificandole los cambios.');
       
       $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findBy(array(
            'idRolInstitucion' => $ascenso->getIdRolInstitucion()->getId()
        ));
       
       $antiguedad = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
            'idRolInstitucion' => $this->getUser()->getIdRolInstitucion(),
            'idServicioCe'  => 1            
        ));
       
       $pida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($serviciosAscenso->getIdRolInstitucion());
       
        return $this->render('cea/ascenso_mostar.html.twig', array(
            'ascenso'   => $ascenso,
            'servicio'      => $serviciosAscenso,            
            'escalas'       => $escala,
            'pida'          => $pida,
            'antiguedad' => $antiguedad
        ));
       
    }
    
    
    
    
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/reconocimiento/escala/{id}/{escala}/{estatus}", name="cea_escala_actualizar")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function actualizarEscalaAction(DocenteServicio $servicio, $escala, $estatus, Request $request)
    {
       $escala_docente = new DocenteEscala();
       if ($request->getMethod() == 'POST') {                      
            $escala_docente->setIdRolInstitucion($servicio->getIdRolInstitucion());
            $escala_docente->setidEscala($this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById($this->get('request')->request->get('escala')));
            $escala_docente->setFechaEscala(new \DateTime($this->get('request')->request->get('fecha_escala')));
            $escala_docente->setIdTipoEscala($this->getDoctrine()->getRepository('AppBundle:TipoAscenso')->findOneById($this->get('request')->request->get('tipo')));
            
            
            
            $em = $this->getDoctrine()->getManager();            
            $em->persist($escala_docente);
            
            if ($this->get('request')->request->get('tipo') == 2 ){
                $ServicioAscenso = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
                    'idRolInstitucion'  => $servicio->getIdRolInstitucion(),
                    'idServicioCe'      => 5,
                    'idEstatus'         => 1
                ));
                
                
                $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
                    'idRolInstitucion'  => $servicio->getIdRolInstitucion(),
                    'idEstatus'         => 1
                ));
                
                
                $ServicioAscenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(4));
                $ascenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(4));
                $em->persist($ServicioAscenso);
                $em->persist($ascenso);
            }
            
            $servicio->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(4));
            $em->persist($servicio);
            
            $em->flush();
       }
       
       
       $this->addFlash('success', 'Escala Agregada Satisfactoriamente');
       return $this->redirect($this->generateUrl('cea_index'));  
       
    }
    
    
    /**
     * Muestra la página donde explica brevemente el reconocimiento de Antiguedad
     * y permite realizar la solicitud
     *
     * @Route("/mis_servicios/ascenso/resumen/{id}", name="ascenso_resumen")
     * @Method({"GET", "POST"})
     */
    public function resumenAscensoImprimirAction(DocenteServicio $servicio){
        
       
       
       if($servicio->getIdEstatus()->getId() == 1){         
            
            $correlativo = $this->getDoctrine()->getRepository('AppBundle:Memorando')->findOneByIdDocenteServicio($servicio->getId());
            $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(
                array('idRolInstitucion'  => $servicio->getIdRolInstitucion()),
                array('id' => 'DESC')
            );
            $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
            $oposcion = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
            $ultimaEscala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(
                array('idRolInstitucion'  => $servicio->getIdRolInstitucion()),
                array('id' => 'DESC')
            );
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
     
            return $this->render('memorando/ascenso.html.twig', array(
                'ascenso'       =>  $ascenso,  
                'correlativo'   => $memorando,
                'adscripcion'   => $adscripcion,
                'oposicion'     => $oposcion,
                'ultimaEscala'  => $ultimaEscala,
                'servicio'     => $servicio
            ));
        
        
       }else{
           
           $this->addFlash('danger', 'No Puede Imprimir el el resumen de solicitud de ascenso hasta no haber estado aprobada dicha solicitud.');
       
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

function thumbnail2 ($filename, $fuente, $destino){
    $im = false;
     if(preg_match('/[.](jpeg)$/', $filename)) {
        $im = imagecreatefromjpeg($fuente . "/" . $filename);
    } else if (preg_match('/[.](jpg)$/', $filename)) {
        $im = imagecreatefromjpeg($fuente . "/" . $filename);
    }else if (preg_match('/[.](gif)$/', $filename)) {
        $im = imagecreatefromgif($fuente . "/" . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng($fuente . "/" . $filename);
    }
    if($im){
        $ox = imagesx($im);
        $oy = imagesy($im);

        $nx = 80;
        $ny = 80;

        $nm = imagecreatetruecolor($nx, $ny);

        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

        imagejpeg($nm, $destino . "/" . $filename);
    }
}

