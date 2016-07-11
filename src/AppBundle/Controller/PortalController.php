<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Usuarios;

class PortalController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\SolicitarType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $persona = $this->getDoctrine()->getRepository('AppBundle:Persona')
                              ->findOneByCedulaPasaporte($form->get('cedula')->getData());
            
             if (!$persona) {
                $this->addFlash('danger', 'Docente no Registrado en la Base de Datos del Centro de Estudios.  Por Favor');
                return $this->redirect(
                    sprintf('%s#%s', '/', 'adscripcion')
                );
            }
            
            //1. obtener el rol-institucion-persona
            $rol = $this->getDoctrine()->getRepository(
                'AppBundle:RolInstitucion')->findOneByIdRol(
                    $this->getDoctrine()->getRepository(
                        'AppBundle:Rol')->findOneByIdPersona($persona));

            //si no existe el rol del docente, enviar correo al encargado de la región para verificar.
            if (!$rol) {
                $this->addFlash('danger', 'Docente no Registrado en la Base de Datos del Centro de Estudios.  Por Favor');
                return $this->redirect(
                    sprintf('%s#%s', '/', 'adscripcion')
                );
            }

            //si el docente existe, crea el nombre de usuario.
            $usuario = mb_strtolower($rol->getIdRol()->getIdPersona()->getPrimerNombre()[0] .$rol->getIdRol()->getIdPersona()->getPrimerApellido());
            //busca en la base de datos para ver si ese nombre de usuario ya existe
            $credenciales = $this->getDoctrine()->getRepository('AppBundle:Usuarios')->findOneByUsername($usuario);
            if(!$credenciales){ //si no existe, procede a crear usuario y contraseña.
                $login = new Usuarios();
                $login->setUsername($usuario);
                $login->setPlainPassword($form->get('cedula')->getData());
                $password = $this->get('security.password_encoder')
                    ->encodePassword($login, $login->getPlainPassword()); //encripta la contraseña
                $login->setPassword($password);
                $login->setIdRolInstitucion($rol);
                $permiso = $this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName("ROLE_DOCENTE");
                $login->addRol($permiso); //le añade la permisología básica de docente
                
                $rep = $this->getDoctrine()->getRepository('AppBundle:Rol');
                //Actualizar el PFG de la persona
                $actualizarRol = $rep->findOneByIdPersona($rol->getIdRol()->getIdPersona());
                $actualizarRol->setIdAreaPersona($form->get('pfg')->getData() );
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($login);
                $em->persist($actualizarRol);
                
                $em->flush(); //guarda en la base de datos
                
                $this->addFlash('notice', 'Datos enviados Satisfactoriamente.  Hemos enviado un correo a la dirección suministrada con los datos para el ingreso');


                $message = \Swift_Message::newInstance()
                    ->setSubject('Bienvenido al sistema CEA@UBV')
                    ->setFrom('wilmer.ramones@gmail.com')
                    ->setTo($form->get('correo')->getData())
                    ->setBody(
                        $this->renderView(
                            'correos/solicitud_adscripcion.html.twig',
                            array(
                                'nombres'   => $form->get('nombres')->getData(),
                                'apellidos' => $form->get('apellidos')->getData(),
                                'usuario'   => $login->getUsername(),
                                'contra'    => $login->getPlainPassword(),

                            )
                        ),
                        'text/html'
                    )
                    /*
                     * If you also want to include a plaintext version of the message
                    ->addPart(
                        $this->renderView(
                            'Emails/registration.txt.twig',
                            array('name' => $name)
                        ),
                        'text/plain'
                    )*/
                    
                ;
                $this->get('mailer')->send($message);           


            }else{
               $this->addFlash('notice', 'Ya ha solicitado datos de ingreso.  Revise la dirección de correo suministrada o Contáctenos a través de: cea.ubv@gmail.com');
               
            }
           
           return $this->redirect(
                    sprintf('%s#%s', '/', 'adscripcion')
                );
            //$request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');
        }

        // replace this example code with whatever you need
        return $this->render('portal/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'form' => $form->createView(),
        ));
    }
}