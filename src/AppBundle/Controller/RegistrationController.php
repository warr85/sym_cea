<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 09:08 AM
 */

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\Usuarios;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Adscripcion;
use AppBundle\Entity\DocenteEscala;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        
	   $adscripcion = new Adscripcion();
	   $escala = new DocenteEscala();
        $form = $this->createForm('AppBundle\Form\UserType');
	   $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        	  //var_dump($user = $this->getUser()->getIdRolInstitucion()->getId()); exit;
		 // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $constanciaTrabajo = $form->get('trabajo')->getData();
            $constanciaPregrado = $form->get('pregrado')->getData();
            
            

            // Generate a unique name for the file before saving it
            $nombreTrabajo = md5(uniqid()).'.'.$constanciaTrabajo->guessExtension();
            $nombrePregrado = md5(uniqid()).'.'.$constanciaPregrado->guessExtension();

            // Move the file to the directory where brochures are stored
            $constanciaTrabajo->move(
                $this->container->getParameter('adscripcion_directory'),
                $nombreTrabajo
            );
            
             $constanciaPregrado->move(
                $this->container->getParameter('adscripcion_directory'),
                $nombrePregrado
            );
            
            if($form->get('postgrado')->getData()) {
            	$constanciaPostgrado = $form->get('postgrado')->getData();
            	$nombrePostgrado = md5(uniqid()).'.'.$constanciaPregrado->guessExtension();
            	$constanciaPostgrado->move(
                	$this->container->getParameter('adscripcion_directory'),
                	$nombrePostgrado
            	);
            }

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $adscripcion->setTrabajo($nombreTrabajo);
            $adscripcion->setPregrado($nombrePregrado);            
            $adscripcion->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $escala->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $escala->setFechaEscala($form->get('fecha_oposicion')->getData());
            $escala->setIdEscala($form->get('escala')->getData());
           
            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($adscripcion);
            $em->persist($escala);
            
            $em->flush(); //guarda en la base de datos
            

            

            //return $this->redirect($this->generateUrl('app_product_list'));	
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
