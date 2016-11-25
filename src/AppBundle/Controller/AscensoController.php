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


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AscensoController extends Controller
{
    /**
     * @Route("/solicitud/ascenso", name="cea_solicitud_ascenso")
     */
    public function ascensoAction(Request $request)
    {
        
	//si ya tiene una solicitud en espera, enviarlo a la pagina de los  servicios
	$solicitud = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idServicioCe' => 5)                
        );
        if($solicitud){
            if($solicitud->getIdEstatus()->getId() != 4 ){
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
        
        $siguiente = $escala->getIdEscala()->getId() + 1;
        $ascenso = new Ascenso();
        if($siguiente < 6){
            $nueva_escala = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById($siguiente);
        }else{
            return $this->redirect($this->generateUrl('servicios_index'));
        }
        
        
        
        
   
        $form = $this->createForm('AppBundle\Form\AscensoType');
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
            $ascenso->setIdEscalafones($nueva_escala);
            $ascenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(2));


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


                
            
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(5));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));

            $em->persist($servicios);
            $em->persist($ascenso);

            $em->flush(); //guarda en la base de datos
            

            

            return $this->redirect($this->generateUrl('cea_index'));	
        }

        return $this->render(
            'solicitudes/ascenso.html.twig',
            array(
                'form' => $form->createView(),
                'ultima_escala' => $escala,
                'nueva_escala'  => $nueva_escala
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
         
         
	
        $form = $this->createForm('AppBundle\Form\ReconocimientoEscalaType');
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {       
            
            
            $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $constanciaAscenso = $form->get('reconocimiento')->getData();
            
            $nombreAscenso = md5(uniqid()).'.'.$constanciaAscenso->guessExtension();

            // Guardar el archivo y crear la miniatura de cada uno
            if (!$concurso->getOposicion()){
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
            }
            if (!$concurso->getOposicion()){
                $adscripcion->setOposicion($nombreAscenso);
            }else{
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
     * Encuentra y muestra una entidad de tipo Adscripción.
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
            'idRolInstitucion' => $this->getUser()->getIdRolInstitucion(),
            'idServicioCe'  => 1            
        ));

        return $this->render('cea/ascenso_mostar.html.twig', array(
            'ascenso' => $ascenso, 
            'servicio'  => $servicio,
            'escalas' => $escala,            
            'pida'      => $pida,
            'antiguedad' => $antiguedad
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
    
    
    
    
     
}

/*funcion para crear miniaturas de las imagenes y carga más rapido la página */

function thumbnail2 ($filename, $fuente, $destino){   
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

