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
        
        if($solicitud->getIdEstatus()->getId() != 5 ){
            return $this->redirect($this->generateUrl('servicios_index'));	
        }
        
        
        //obtener su ultimo escalafon
        $escala = $this->getDoctrine()->getRepository('AppBundle:DocenteEscala')->findOneBy(
                array('idRolInstitucion'  => $this->getUser()->getIdRolInstitucion()),
                array('id' => 'DESC')
        );
        
        $siguiente = $escala->getIdEscala()->getId() + 1;
        $ascenso = new Ascenso();
        if($siguiente < 6){
            $nueva_escala = $this->getDoctrine()->getRepository('AppBundle:Escalafones')->findOneById($siguiente);
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
            thumbnail($nombreTrabajo, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
             
            
             $constanciaExpediente->move(
                $this->container->getParameter('ascenso_directory'),
                $nombreExpediente
            );
            thumbnail($nombreExpediente, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            
            $constanciaPida->move(
                $this->container->getParameter('ascenso_directory'),
                $nombrePida
            );
            thumbnail($nombrePida, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            
            
            $constanciaNai->move(
                $this->container->getParameter('ascenso_directory'),
                $nombreNai
            );
            thumbnail($nombreNai, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
            
            if($form->get('investigacion')->getData()) {
                /** @var UploadedFile $constanciaPostgrado */
            	$constanciaInvestigacion = $form->get('investigacion')->getData();
            	$nombreInvestigacion = md5(uniqid()).'.'.$constanciaInvestigacion->guessExtension();
            	$constanciaInvestigacion->move(
                	$this->container->getParameter('ascenso_directory'),
                	$nombreInvestigacion
            	);
                    thumbnail($nombreInvestigacion, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
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
                thumbnail($nombrePertinencia, $this->container->getParameter('ascenso_directory'), $this->container->getParameter('ascenso_thumb_directory'));
                $ascenso->setPertinencia($nombrePertinencia);
                $ascenso->setIdLineaInvestigacion($form->get('lineas_investigacion')->getData());                                

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
        
        $ascenso = $this->getDoctrine()->getRepository('AppBundle:Ascenso')->findOneByIdRolInstitucion($servicio->getIdRolInstitucion());
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
     * @Route("/solicitudes/ascenso/{id}/{estatus}", name="cea_ascenso_actualizar")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_COORDINADOR_REGIONAL')")
     */
    public function solicitudesAscensoEditAction(Ascenso $ascenso, $estatus)
    {
        
       //$adscripciones = $this->getDoctrine()->getRepository('AppBundle:Adscripcion')->findOneById($adscripcion->getId());
       $serviciosAscenso = $this->getDoctrine()->getRepository('AppBundle:DocenteServicio')->findOneBy(array(
           'idRolInstitucion'   => $ascenso->getIdRolInstitucion(),
           'idServicioCe'       => 5
       ));
       
       
              
       $user = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByIdRolInstitucion($ascenso->getIdRolInstitucion());
       if($estatus == "true") {
           $serviciosAscenso->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:Estatus')->findOneById(1));                      
                                            
       }else{
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
                                'estatus'   => $serviciosAscenso->getIdEstatus()
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
    
    
    
    
     
}

