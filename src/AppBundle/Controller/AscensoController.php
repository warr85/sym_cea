<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 09:08 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\AscensoPertinencia;
use AppBundle\Entity\AscensoTutores;
use AppBundle\Entity\DocumentosVerificados;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Ascenso;
use AppBundle\Entity\DocenteEscala;
use AppBundle\Entity\Memorando;
use AppBundle\Entity\DocenteServicio;
use AppBundle\Entity\TutoresAscenso;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;

class AscensoController extends Controller
{
    /**
     * @Route("/solicitud/ascenso", name="cea_solicitud_ascenso")
     */
    public function ascensoAction(Request $request)
    {
        $formalizarTiempo = false;

        $adscrito = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
            array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idServicioCe' => 2, 'idEstatus' => 1),
            array('id' => 'DESC')
        );

        if(!$adscrito){
                $this->addFlash('warning', 'Su Adscripción está en Espera, Al cambiar a aprobada se le notifcará por correo');
                return $this->redirect($this->generateUrl('servicios_index'));
        }

	//si ya tiene una solicitud en espera, enviarlo a la pagina de los  servicios
	$solicitud = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idServicioCe' => 5),
                array('id' => 'DESC')                
        );
        if($solicitud){
            if($solicitud->getIdEstatus()->getId() != 4 ){
                $this->addFlash('warning', 'Ya usted posee una solicitud de Ascenso en espera.  Puede consultar su estatus en el botón de "Mis servicios".  Recuerde que al tener a la mano su constancia de aprobación de ascenso, debe subirla en el botón de servicios en el apartado Reconocimiento de nuevo Escalafón. ');
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


        if ($form->isSubmitted()) {
            //var_dump((!$form->get('tutores_ascenso')->getData()->toArray())); exit;
            if ($form->get('tipoTrabajoInvestigacion')->getData() === "tesis") {
                //var_dump($form);
                if (!$form->get('aprobacion')->getData()) {
                    $form->get('aprobacion')->addError(new FormError('Si su trabajo es tesis, debe subir el digital del acta de aprobación de la misma'));
                }

                if ($form->get('tesisUbv')->getData()) {
                    if (!$form->get('tutores_ascenso')->getData()->toArray()) {
                        $form->get('tutores_ascenso')->addError(new FormError('La tesis al ser fuera de la UBV debe postular seis(6) posibles jurados'));
                    }

                    if (!$form->get('curriculo')->getData()) {
                        $form->get('curriculo')->addError(new FormError('Debe subir el digital del resumen curricular de los posibles jurados en fomato PDF'));
                    }

                    if (!$form->get('pertinencia')->getData()) {
                        $form->get('pertinencia')->addError(new FormError('La tesis al ser fuera de la UBV debe incluir un informe de pertinencia'));
                    }

                    if (!$form->get('titulo_pertinencia')->getData()) {
                        $form->get('titulo_pertinencia')->addError(new FormError('La tesis al ser fuera de la UBV debe incluir el titulo del informe de pertinencia'));
                    }

                    if (!$form->get('lugar_pertinencia')->getData()) {
                        $form->get('pertinencia')->addError(new FormError('La tesis al ser fuera de la UBV debe incluir el lugar donde se defendió'));
                    }

                    if (!$form->get('fecha_defensa')->getData()) {
                        $form->get('pertinencia')->addError(new FormError('La tesis al ser fuera de la UBV debe incluir la fecha de defensa'));
                    }
                }

            }else if ($form->get('tipoTrabajoInvestigacion')->getData() === "investigacion"){
                if (!$form->get('tutores_ascenso')->getData()->toArray()) {
                    $form->get('tutores_ascenso')->addError(new FormError('La tesis al ser fuera de la UBV debe postular seis(6) posibles jurados'));
                }

                if (!$form->get('curriculo')->getData()) {
                    $form->get('curriculo')->addError(new FormError('Debe subir el digital del resumen curricular de los posibles jurados en fomato PDF'));
                }
            }
        }
                	        

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(5));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));

            $em->persist($servicios);
            $em->flush();

            

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
                verificar_documentos2($this->getUser()->getIdRolInstitucion(),15,2,$em,$nombreInvestigacion, $servicios);
            }



            verificar_documentos2($this->getUser()->getIdRolInstitucion(),1,2,$em,$nombreTrabajo, $servicios);
            verificar_documentos2($this->getUser()->getIdRolInstitucion(),11,2,$em,$nombreExpediente, $servicios);
            verificar_documentos2($this->getUser()->getIdRolInstitucion(),9,2,$em,$nombrePida, $servicios);
            verificar_documentos2($this->getUser()->getIdRolInstitucion(),12,2,$em,$nombreNai, $servicios);

            $ascenso = new Ascenso();
            $ascenso->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());

            $ascenso->setTituloTrabajo($form->get('titulo_trabajo')->getData());
            $ascenso->setTipoTrabajoInvestigacion($form->get('tipoTrabajoInvestigacion')->getData());
            $ascenso->setTesisUbv(!$form->get('tesisUbv')->getData());
            $ascenso->setNombreNucelo($form->get('nombreNucleo')->getData());
            $ascenso->setIdEscalafones($nueva_escala);
            $ascenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(2));
            $em->persist($ascenso);
            $em->flush();
            
            
            $tutores = $form->get('tutores_ascenso')->getData();
            foreach ($tutores as $tutor){
                $ascensoTutor = new AscensoTutores();
                $ascensoTutor->setIdAscenso($ascenso);
                $ascensoTutor->setIdTutor($tutor);
                $ascensoTutor->setIdEstatus($em->getRepository("AppBundle:Estatus")->findOneById(2));
                $em->persist($ascensoTutor);
                $em->flush();
            }
            
            
            if ($form->get('pertinencia')->getData()){

                $pertinencia = new AscensoPertinencia();
                $pertinencia->setIdAscenso($ascenso);
                $pertinencia->setTituloPertinencia($form->get('titulo_pertinencia')->getData());
                $pertinencia->setLugarPertinencia($form->get('lugar_pertinencia')->getData());
                $pertinencia->setFechaDefensa($form->get('fecha_defensa')->getData());

                $em->persist($pertinencia);
                
                $constanciaPertinencia = $form->get('pertinencia')->getData();
                $nombrePertinencia = md5(uniqid()).'.'.$constanciaPertinencia->guessExtension();
                $constanciaPertinencia->move(
                    $this->container->getParameter('ascenso_directory'),
                    $nombrePertinencia
                );
                thumbnail2($nombrePertinencia, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                verificar_documentos2($this->getUser()->getIdRolInstitucion(),14,2,$em,$nombrePertinencia, $servicios);
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
                verificar_documentos2($this->getUser()->getIdRolInstitucion(),13,2,$em,$nombreAprobacion, $servicios);
                //$ascenso->setIdLineaInvestigacion($form->get('lineas_investigacion')->getData());                                

            }
            
            
            if ($form->get('curriculo')->getData()){
                
                $constanciaCurriculo = $form->get('curriculo')->getData();
                $nombreCurriculo = md5(uniqid()).'.'.$constanciaCurriculo->guessExtension();
                $constanciaCurriculo->move(
                    $this->container->getParameter('ascenso_directory'),
                    $nombreCurriculo
                );

                //thumbnail2($nombreCurriculo, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                verificar_documentos2($this->getUser()->getIdRolInstitucion(),16,2,$em,$nombreCurriculo, $servicios);

            }


                
            


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

        $form = $this->createForm('AppBundle\Form\ReconocimientoEscalaType');
        $concurso = $this->getDoctrine()->getRepository('AppBundle:DocumentosVerificados')->findOneBy(array(
            'idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(),
            'idTipoDocumentos' => 4
        ));



        //si ya tiene una solicitud en espera, enviarlo a la pagina de los  servicios
	    $solicitud = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idServicioCe' => 5, 'idEstatus' => 1)                
        );
        
        
       if ($concurso && !$solicitud){
           $this->addFlash('danger', 'Debe tener una solicitud de Ascenso Activa para poder utilizar este servicio');
           return $this->redirect($this->generateUrl('cea_index'));
       }

       $acta = $this->getDoctrine()->getRepository("AppBundle:DocenteServicio")->findOneBy(array(
          'idRolInstitucion' =>  $this->getUser()->getIdRolInstitucion(),
           'idServicioCe' => 7,
           'idEstatus' => 1
       ));

        if ($concurso && !$acta){
            $this->addFlash('danger', 'Debe enviar primero su acta de aprobación de jurados para poder defender y subir su nuevo escalafón');
            return $this->redirect($this->generateUrl('cea_index'));
        }
        

         
         
         $solicitudAscenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(
                array(
                    'idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(),
                    'idEstatus'         => 1
                )                
        );


        if($concurso && !$solicitudAscenso){
            $this->addFlash('danger', 'Estimado Docente, No posee ninguna solicitud de Ascenso Activa.');
            return $this->redirect($this->generateUrl('cea_index'));
        }
         
         

        
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(6));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));
            $em->persist($servicios);
            $em->flush();
            
            
            $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $constanciaAscenso = $form->get('reconocimiento')->getData();
            
            $nombreAscenso = md5(uniqid()).'.'.$constanciaAscenso->guessExtension();

            // Guardar el archivo y crear la miniatura de cada uno
            if (!$concurso){
                $constanciaAscenso->move(
                    $this->container->getParameter('adscripcion_directory'),
                    $nombreAscenso
                );             
                thumbnail2($nombreAscenso, $this->container->getParameter('adscripcion_directory'), $this->container->getParameter('adscripcion_thumb_directory'));

                verificar_documentos2($adscripcion->getIdRolInstitucion(),4,2,$em,$nombreAscenso, $servicios);
            }else{
                $constanciaAscenso->move(
                    $this->container->getParameter('ascenso_directory'),
                    $nombreAscenso
                );             
                thumbnail2($nombreAscenso, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                switch ($solicitudAscenso->getIdEscalafones()->getId()){
                    case 2: verificar_documentos2($adscripcion->getIdRolInstitucion(),5,2,$em,$nombreAscenso, $servicios);
                        break;
                    case 3: verificar_documentos2($adscripcion->getIdRolInstitucion(),6,2,$em,$nombreAscenso, $servicios);
                        break;
                    case 4: verificar_documentos2($adscripcion->getIdRolInstitucion(),7,2,$em,$nombreAscenso, $servicios);
                        break;
                    case 5: verificar_documentos2($adscripcion->getIdRolInstitucion(),8,2,$em,$nombreAscenso, $servicios);
                        break;
                    default:
                        break;
                }
            }
                      
            
            

            $em->persist($adscripcion);
            
            $em->flush();
            $this->addFlash('success', 'Solicitud de Reconocimiento de escala Registrada Satisfactoriamente');
            return $this->redirect($this->generateUrl('cea_index'));		
        }

        if(!$concurso){
            return $this->render(
                'solicitudes/reconocimientoEscala.html.twig',
                array(
                    'form' => $form->createView(),
                    'tipo'  => 'Concurso de Oposición'
                )
            );
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
     * @Route("/solicitud/reconocimiento/acta_defensa", name="cea_solicitud_acta_defensa")
     */
    public function actaDefensaAction(Request $request)
    {


        //si ya tiene una solicitud en espera, enviarlo a la pagina de los  servicios
        $solicitud = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
            array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idServicioCe' => 5, 'idEstatus' => 1)
        );


        if (!$solicitud){
            $this->addFlash('danger', 'Debe tener una solicitud de Ascenso Activa para poder utilizar este servicio');
            return $this->redirect($this->generateUrl('cea_index'));
        }

$ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(
    array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(), 'idEstatus' => 1)
);
        $solicitudDefensa = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(
            array(
                'idRolInstitucion'  => $this->getUser()->getIdRolInstitucion(),
                'idServicioCe'      => 7
            ),
            array('id' => 'DESC')
        );


        if($solicitudDefensa && ($solicitudDefensa->getIdEstatus()->getId() == 1 || $solicitudDefensa->getIdEstatus()->getId() == 2) ){
            $this->addFlash('warning', 'Estimado Docente, Ya posee una solicitud Activa, ¿desea imprimirla? busque en mis servicios solicitados un acta de defensa activa');
            return $this->redirect($this->generateUrl('servicios_index'));
        }


        $form = $this->createForm('AppBundle\Form\ActaDefensaType');

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            //Crear la solicitud de Servicio
            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(7));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));
            $em->persist($servicios);
            $em->flush();


            $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $constanciaActa = $form->get('acta')->getData();

            $nombreActa = md5(uniqid()).'.'.$constanciaActa->guessExtension();

            // Guardar el archivo y crear la miniatura de cada uno

            $constanciaActa->move(
                $this->container->getParameter('ascenso_directory'),
                $nombreActa
            );
            thumbnail2($nombreActa, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            verificar_documentos2($adscripcion->getIdRolInstitucion(),17,2,$em,$nombreActa, $servicios);

            $em->persist($adscripcion);

            $em->flush();
            $this->addFlash('success', 'Solicitud de verificar Acta de Defensa Registrada Satisfactoriamente');
            return $this->redirect($this->generateUrl('cea_index'));
        }

        return $this->render(
            'solicitudes/acta_defensa.html.twig',
            array(
                'form' => $form->createView(),
                'tipo'  => 'Ascenso ' . $ascenso->getIdEscalafones()->getNombre()
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


        $docente = $this->getDoctrine()->getRepository("AppBundle:RolInstitucion")->findOneById($servicio->getIdRolInstitucion()->getId());
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion()->getId()
        ));
        
        $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion(),
            'idEstatus'         => 2
        ));
        
        if(!$ascenso){
            $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
                'idRolInstitucion' => $servicio->getIdRolInstitucion()),            
                array('id' => 'DESC')
            );
        }

        $servicioPida = $this->getDoctrine()->getRepository("AppBundle:DocenteServicio")->findOneBy(array(
            'idRolInstitucion' => $docente,
            'idServicioCe' => 4),
            array('id' => 'DESC')
        );
        //$pida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        $antiguedad = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion(),
            'idServicioCe'  => 1            
        ));
        
         $form = $this->createForm('AppBundle\Form\AddTutorType');

        return $this->render('cea/ascenso_mostar.html.twig', array(
            'ascenso' => $ascenso, 
            'servicio'  => $servicio,
            'escalas' => $escala,            
            'servicioPida'      => $servicioPida,
            'antiguedad' => $antiguedad,
            'form' => $form->createView(),
            'docente' => $docente
        ));
    }
    
    
    
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/reconocimientoEscala/{id}", name="cea_reconocimientoEscala_show")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function reconocimientoEscalaShowAction(DocenteServicio $servicio, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $docente = $em->getRepository("AppBundle:RolInstitucion")->findOneById($servicio->getIdRolInstitucion()->getId());

        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion()->getId()
        ));
        
        
        $adscripcion = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        
        $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
           'idRolInstitucion'   =>  $servicio->getIdRolInstitucion(),
            'idEstatus'         =>  1
        ));
                
        $pida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        $ano = 2003;
        if($ascenso == NULL){
            $escalafones = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findAll();
        }else{
            $escalafones = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById($ascenso->getIdEscalafones()->getId());
            $ano = end($escala)->getFechaEscala()->format('Y');;
        }



        $form = $this->createFormBuilder()

            ->add('fechaAscenso', BirthdayType::class, array(
                'widget' => 'choice',
                'label' => 'Fecha de Ascenso',
                'years' => range($ano, date("Y")),
                'placeholder' => array(
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
                ),
                'constraints' => array(
                    new NotBlank(),
                    new Date()
                )
            ))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $parametros = $request->request->all();
            $verificado = $this->getDoctrine()->getRepository("AppBundle:DocumentosVerificados")->findOneByIdServicio($servicio);
            $ServicioAscenso = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
                'idRolInstitucion'  => $servicio->getIdRolInstitucion(),
                'idServicioCe'      => 5,
                'idEstatus'         => 1
            ));


            $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
                'idRolInstitucion'  => $servicio->getIdRolInstitucion(),
                'idEstatus'         => 1
            ));

            $servicioDefensa = $this->getDoctrine()->getRepository("AppBundle:DocenteServicio")->findOneBy(array(
                'idRolInstitucion' => $docente,
                'idServicioCe' => 7),
                array('id' => 'DESC')
            );

            if(isset($parametros['aprobado'])) {
                $verificado->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));
                $escala_docente = new DocenteEscala();
                $escala_docente->setIdRolInstitucion($servicio->getIdRolInstitucion());
                $escala_docente->setidEscala($this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById($this->get('request')->request->get('escala')));
                $escala_docente->setFechaEscala($data['fechaAscenso']);
                $escala_docente->setIdTipoEscala($this->getDoctrine()->getRepository('AppBundle:TipoAscenso')->findOneById($this->get('request')->request->get('tipo')));
                $em->persist($escala_docente);


                $servicio->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(4));

                if($servicioDefensa) $servicioDefensa->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(4));
                if($ServicioAscenso) $ServicioAscenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(4));
                if($ascenso) $ascenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(4));

            }else{
                //$mensaje = $request->request->get('message-text');
                $verificado->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));
                $servicio->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));
                $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
                    'idRolInstitucion'  => $servicio->getIdRolInstitucion(),
                    'idEstatus'         => 1
                ));

                $servicio->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));


            }

            if($ServicioAscenso) $em->persist($ServicioAscenso);
            if($servicioDefensa) $em->persist($servicioDefensa);
            if($ascenso) $em->persist($ascenso);
            $em->persist($verificado);
            $em->flush();
            $this->addFlash('success', 'Escala Agregada Satisfactoriamente');
            return $this->redirect($this->generateUrl('cea_index'));

        }


        return $this->render('cea/reconocimiento_escala_mostrar.html.twig', array(
            'ascenso' => $ascenso, 
            'adscripcion' => $adscripcion,
            'servicio'  => $servicio,
            'escalas' => $escala,            
            'pida'      => $pida,
            'escalafones' => $escalafones,
            'docente'       => $docente,
            'form'      => $form->createView()
            
        ));
    }





    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/acta_defensa/{id}", name="cea_acta_defensa_show")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function actaDefensaShowAction(DocenteServicio $servicio, Request $request)
    {
        $docente = $this->getDoctrine()->getRepository("AppBundle:RolInstitucion")->findOneById($servicio->getIdRolInstitucion()->getId());
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion()->getId()
        ));

        $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion(),
            'idEstatus'         => 2
        ));

        if(!$ascenso){
            $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
                'idRolInstitucion' => $servicio->getIdRolInstitucion()),
                array('id' => 'DESC')
            );
        }

        $servicioPida = $this->getDoctrine()->getRepository("AppBundle:DocenteServicio")->findOneBy(array(
            'idRolInstitucion' => $docente,
            'idServicioCe' => 4),
            array('id' => 'DESC')
        );



        //$pida = $this->getDoctrine()->getRepository('AppBundle:AdscripcionPida')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
        $antiguedad = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
            'idRolInstitucion' => $servicio->getIdRolInstitucion(),
            'idServicioCe'  => 1
        ));

        $form = $this->createForm('AppBundle\Form\AddTutorType');

        return $this->render('cea/acta_defensa_mostar.html.twig', array(
            'ascenso' => $ascenso,
            'servicio'  => $servicio,
            'escalas' => $escala,
            'servicioPida'      => $servicioPida,
            'antiguedad' => $antiguedad,
            'form' => $form->createView(),
            'docente' => $docente
        ));


    }
    
    
    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/solicitudes/ascenso/{id}", name="cea_ascenso_actualizar")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function solicitudesAscensoEditAction(Ascenso $ascenso, Request $request)
    {
        $mensaje = "";
       //$adscripciones = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneById($adscripcion->getId());
       $serviciosAscenso = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
           'idRolInstitucion'   => $ascenso->getIdRolInstitucion(),
           'idServicioCe'       => 5,
           'idEstatus'          => 2
       ));

        $parametros = $request->request->all();
        $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($ascenso->getIdRolInstitucion());

        if(isset($parametros['aprobado'])) {
           $serviciosAscenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));

       }else{
           $mensaje = $request->request->get('message-text');
           $serviciosAscenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));           
       }
       
       $ascenso->setIdEstatus($serviciosAscenso->getIdEstatus());
        $em = $this->getDoctrine()->getManager();


        //Guardar el resultado de la verificación de Documentos
        foreach ($parametros as $key => $value){
            if($key === 'trabajo') {
                verificar_documentos2($user->getIdRolInstitucion(), 1, $value, $em, "", $serviciosAscenso);
            }else if($key === 'pida') {
                verificar_documentos2($user->getIdRolInstitucion(), 9, $value, $em, "", $serviciosAscenso);
            }else if($key === 'nai') {
                verificar_documentos2($user->getIdRolInstitucion(), 12, $value, $em, "",  $serviciosAscenso);
            }else if($key === 'tesis') {
                verificar_documentos2($user->getIdRolInstitucion(), 13, $value, $em, "", $serviciosAscenso);
            }else if($key === 'actividades') {
                verificar_documentos2($user->getIdRolInstitucion(), 10, $value, $em, "", $serviciosAscenso);
            }else if($key === 'cath') {
                verificar_documentos2($user->getIdRolInstitucion(), 11, $value, $em, "", $serviciosAscenso);
            }else if($key === 'investigacion') {
                verificar_documentos2($user->getIdRolInstitucion(), 15, $value, $em, "", $serviciosAscenso);
            }else if($key === 'curriculo') {
                verificar_documentos2($user->getIdRolInstitucion(), 16, $value, $em, "", $serviciosAscenso);
            }else if($key === 'pertinencia') {
                verificar_documentos2($user->getIdRolInstitucion(), 14, $value, $em, "", $serviciosAscenso);
            }
        }
           
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


        return $this->redirect($this->generateUrl('cea_ascenso_show', array('id' => $serviciosAscenso->getId())));
       
    }



    /**
     * Encuentra y muestra una entidad de tipo Adscripción.
     *
     * @Route("/solicitudes/acta_defensa_edit/{id}", name="cea_acta_defensa_actualizar")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function actaDefensaEditAction(Ascenso $ascenso, Request $request)
    {
        $mensaje = "";
        //$adscripciones = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneById($adscripcion->getId());
        $servicioDefensa = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
            'idRolInstitucion'   => $ascenso->getIdRolInstitucion(),
            'idServicioCe'       => 7,
            'idEstatus'          => 2
        ));

        $parametros = $request->request->all();
        $resolucion = $parametros["resolucion"];

        $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($ascenso->getIdRolInstitucion());

        if(isset($parametros['aprobado'])) {
            $servicioDefensa->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));

        }else{
            $mensaje = $request->request->get('message-text');
            $servicioDefensa->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(3));
        }

        $em = $this->getDoctrine()->getManager();


        //Guardar el resultado de la verificación de Documentos
        foreach ($parametros as $key => $value){
            if($key === 'defensa') {
                verificar_documentos2($user->getIdRolInstitucion(), 17, $value, $em, "", $servicioDefensa);
            }
            if (strpos($key, "jurado") !== false) {
                $jur = explode("_", $key);
                $actualizar = $this->getDoctrine()->getRepository("AppBundle:AscensoTutores")->findOneById($jur[1]);
                $estatusTutor = $this->getDoctrine()->getRepository("AppBundle:EstatusTutor")->findOneById($value);
                $actualizar->setIdEstatusTutor($estatusTutor);
                $actualizar->setResolucion($resolucion);
                $actualizar->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(1));
                $em->persist($actualizar);
                $em->flush();

            }
        }
        $em->persist($servicioDefensa);
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Resultado Acta de defensa CEA@UBV')
            ->setFrom('wilmer.ramones@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'correos/actualizar_ascenso.html.twig',
                    array(
                        'nombres'   => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerNombre(),
                        'apellidos'   => $user->getIdRolInstitucion()->getIdRol()->getIdPersona()->getPrimerApellido(),
                        'estatus'   => $servicioDefensa->getIdEstatus(),
                        'mensaje'   => $mensaje
                    )
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        $this->addFlash('notice', 'Solicitud Actualizada Correctamente, hemos enviado un correo al docente notificandole los cambios.');


        return $this->redirect($this->generateUrl('cea_acta_defensa_show', array('id' => $servicioDefensa->getId())));

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



    /**
     * Muestra la página donde explica brevemente el reconocimiento de Antiguedad
     * y permite realizar la solicitud
     *
     * @Route("/mis_servicios/acta_defensa/imprimir/{id}", name="servicio_defensa_imprimir")
     * @Method({"GET", "POST"})
     */
    public function serviciosDefensaImprimirAction(DocenteServicio $servicio){


        if ($servicio->getIdEstatus()->getId() == 1){


            $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneBy(array(
                'idRolInstitucion' => $servicio->getIdRolInstitucion(),
                'idEstatus' => 1
            ));
            $pertinencia = $this->getDoctrine()->getRepository("AppBundle:AscensoPertinencia")->findOneByIdAscenso($ascenso);
            $eje = $ascenso->getIdRolInstitucion()->getIdInstitucion()->getIdEjeParroquia()->getIdEje()->getNombre();
            $estado = $ascenso->getIdRolInstitucion()->getIdInstitucion()->getIdEjeParroquia()->getIdParroquia()->getIdMunicipio()->getIdEstado()->getNombre();
            $tutores = $ascenso->getTutores();
            $resolucion = $tutores[0]->getResolucion();

            $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion()),
                array('id' => 'DESC')
            );

            if(!$escala){
                $this->addFlash('danger', 'Estimado Docente, todavia no ha concursado, debe concursar primero para poder realizar una solicitud de ascenso.');
                return $this->redirect($this->generateUrl('cea_index'));
            }

            $escalafones = $this->getDoctrine()->getRepository("AppBundle:Escalafones")->findOneById($escala->getIdEscala()->getId() + 1); //tiempo para el proximo escalafon
            foreach ($tutores as $tutor) {
                if ($tutor->getIdEstatusTutor()->getId() == 1){
                    $presidente = $tutor;
                }

            }


            if ($ascenso->getTipoTrabajoInvestigacion() == "investigacion"  ) {

                return $this->render('memorando/acta_defensa_investigacion.html.twig', array(
                    'ascenso' => $ascenso,
                    'eje' => $eje,
                    'estado' => $estado,
                    'resolucion' => $resolucion,
                    'presidente' => $presidente,
                    'categoria' => $escalafones,
                    'jurados' => $tutores,
                    'pertinencia' => $pertinencia
                ));
            }else if (!$ascenso->getTesisUbv()) {
                return $this->render('memorando/acta_defensa_pertinencia.html.twig', array(
                    'ascenso' => $ascenso,
                    'eje' => $eje,
                    'estado' => $estado,
                    'resolucion' => $resolucion,
                    'presidente' => $presidente,
                    'categoria' => $escalafones,
                    'jurados' => $tutores,
                    'pertinencia' => $pertinencia
                ));

            }else{
                return $this->render('memorando/acta_defensa_investigacion.html.twig', array(
                    'ascenso' => $ascenso,
                    'eje' => $eje,
                    'estado' => $estado,
                    'resolucion' => $resolucion,
                    'presidente' => $presidente,
                    'categoria' => $escalafones,
                    'jurados' => $tutores,
                    'pertinencia' => $pertinencia
                ));
            }

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
    }else{
        move_uploaded_file($filename, $destino);
    }
}


function verificar_documentos2($idRolInstitucion, $tipo, $estatus, $em, $ubicacion="", $servicio = 2){
    $existe = $em->getRepository("AppBundle:DocumentosVerificados")->findOneBy(array(
        'idRolInstitucion' => $idRolInstitucion,
        'idTipoDocumentos'  => $tipo,
        'idServicio'        => $servicio
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
