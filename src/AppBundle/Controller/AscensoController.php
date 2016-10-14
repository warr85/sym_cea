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
            array('form' => $form->createView())
        );
    }
    
    
     
}

