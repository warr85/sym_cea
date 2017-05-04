<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;
use AppBundle\Entity\AscensoTutores;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
 
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\TutoresAscenso;
use AppBundle\Entity\Ascenso;



/**
 * Description of AjaxController
 *
 * @author ubv-cipee
 * 
 * 
 */
 
class AjaxController extends Controller {
    
    /**
     * @Route("/ajax/contador_solicitudes", name="ajax_contador_solicitudes")
     * @Method({"GET"})
     */
    public function contadorAction(Request $request){
       if($request->isXmlHttpRequest()){            
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);
 
            $em = $this->getDoctrine()->getManager();
            if ($this->get('security.authorization_checker')->isGranted('ROLE_COORDINADOR_NACIONAL')){
                $posts =  $em->getRepository('AppBundle:DocenteServicio')->findBy(array(
                    'idEstatus'    => 2
                )); 
                //si no es coordinador nacional, entonces no cuente las solcitudes de antiguedad
                //que son de tipo 1
            }else{
                $repository = $this->getDoctrine()
                ->getRepository('AppBundle:DocenteServicio');
                $query = $repository->createQueryBuilder('p')
                ->where('p.idEstatus = :estatus')
                ->andWhere('p.idServicioCe > :identificador')
                ->setParameters(array('estatus'=> 2, 'identificador' => 2))                
                ->getQuery();
                
                $posts = $query->getResult();
            }
            $cuenta = count($posts);            
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
                'posts' => $serializer->serialize($cuenta, 'json')
            ));
            return $response;
       }
        
    }
    
    
    
    /**
     * @Route("/ajax/buscar_tutor_select", name="ajax_buscar_tutor_select")
     * @Method({"GET"})
     */
    public function buscarTutorSelectAction(Request $request){
       //if($request->isXmlHttpRequest()){            
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);
             
            $term = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);
            $repository = $this->getDoctrine()
            ->getRepository('AppBundle:TutoresAscenso');
            $query = $repository->createQueryBuilder('p')
            ->where('p.nombres LIKE :term')
            ->orWhere('p.apellidos LIKE :term')
            ->setParameter('term', '%'.$term.'%')     
            ->getQuery();

            $posts = $query->getResult();
            
                       
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(                
                'items' => $serializer->serialize($posts, 'json')
            ));
            return $response;
       //}
        
    }
    
    
    /**
     * @Route("/ajax/buscar_tutor", name="ajax_buscar_tutor")
     * @Method({"GET"})
     */
     public function buscarTutorAction(Request $request){
         
       //if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);
            $cedula = filter_input(INPUT_GET, 'cedula', FILTER_SANITIZE_SPECIAL_CHARS);
            $documento = filter_input(INPUT_GET, 'documento', FILTER_SANITIZE_SPECIAL_CHARS);
 

            $repository = $this->getDoctrine()->getRepository('AppBundle:TutoresAscenso')->findOneBy(array(
                'idDocumentoIdentidad' => $documento,
                'cedulaPasaporte'   => $cedula
            ));
            
                               
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
                'posts' => $serializer->serialize($repository, 'json')
            ));
            return $response;
       //}
        
    }
    
    
    /**
     * @Route("/ajax/registrar_tutor", name="ajax_registrar_tutor")
     * @Method({"POST"})
     */
     public function registrarTutorAction(Request $request){
         
       //if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);
           
            $nuevoTutor = new TutoresAscenso();
            $form = $this->createForm('AppBundle\Form\TutoresAscensoType', $nuevoTutor);
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($nuevoTutor);
                $em->flush();
 
                 $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
                'posts' => $serializer->serialize($nuevoTutor, 'json')
            ));
            return $response;
            }
            
            
            
            $response = new JsonResponse(
                    array(
                'message' => $form,
                ), 400);

            return $response;
       //}
        
    }
    
    
    
    /**
     * @Route("/ajax/adicionar_tutor", name="ajax_adicionar_tutor")
     * @Method({"POST"})
     */
     public function adicionarTutorAction(Request $request){
         
       if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);
           
            $jurados = filter_input(INPUT_POST, 'jurados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $ascensoId = filter_input(INPUT_POST, 'ascensoId', FILTER_SANITIZE_SPECIAL_CHARS);
            
            
           $ascenso = $this->getDoctrine()->getRepository("AppBundle:Ascenso")->findOneById($ascensoId);
           $em = $this->getDoctrine()->getManager();
            foreach ($jurados as $jurado){
                $adicionar = $this->getDoctrine()->getRepository("AppBundle:TutoresAscenso")->findOneById($jurado);
                $ascensoTutor = new AscensoTutores();
                $ascensoTutor->setIdAscenso($ascenso);
                $ascensoTutor->setIdTutor($adicionar);
                $ascensoTutor->setIdEstatus($em->getRepository("AppBundle:Estatus")->findOneById(2));
                $em->persist($ascensoTutor);
                $em->flush();

                $nuevos_nombres[] = $ascensoTutor->getIdTutor()->getNombres() . " " . $ascensoTutor->getIdTutor()->getApellidos();
                $nuevos_institucion[] = $ascensoTutor->getIdTutor()->getInstitucion() . " -> " . $ascensoTutor->getIdTutor()->getIdEscala()->getNombre();
                $nuevos_id[] = $ascensoTutor->getIdTutor()->getId();
            }
            
            
            

            $em->persist($ascenso);
            $em->flush();
            
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
                'jurados' => $jurados,
                'adicionar_nombres' => $nuevos_nombres,
                'adicionar_institucion' => $nuevos_institucion,
                'adicionar_id'          => $nuevos_id,
                'ascenso'  => $ascensoId
            ));
            
            return $response;
            
            
       }
        
    }



    /**
     * @Route("/ajax/buscar/parroquias", name="ajax_select_parroquias")
     * @Method({"POST"})
     */
    public function buscarParroquiasAction(Request $request){

        if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);


            $eje = filter_input(INPUT_POST, 'eje_id', FILTER_SANITIZE_SPECIAL_CHARS);
            $eje = $this->getDoctrine()->getRepository("AppBundle:Eje")->findOneById($eje);
            $estados = $this->getDoctrine()->getRepository("AppBundle:EjeParroquia")->findByIdEje($eje);



            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
                'eje'  => $eje,
                'estados' => $serializer->serialize($estados, 'json')
            ));

            return $response;


        }

    }



    /**
     * @Route("/ajax/eliminar/tarea", name="ajax_eliminar_tarea")
     * @Method({"POST"})
     */
    public function eliminarTareaAction(Request $request){

        if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $id = filter_input(INPUT_POST, 'eliminar',  FILTER_SANITIZE_SPECIAL_CHARS);


            $em = $this->getDoctrine()->getManager();
            $tarea = $em->getRepository("AppBundle:PidaTareaEspecifico")->findOneById($id);
            $em->remove($tarea);
            $em->flush();




            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success'
            ));

            return $response;


        }

    }


    /**
     * @Route("/ajax/eliminar/labor", name="ajax_eliminar_labor")
     * @Method({"POST"})
     */
    public function eliminarLaborAction(Request $request){

        if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $id = filter_input(INPUT_POST, 'eliminar',  FILTER_SANITIZE_SPECIAL_CHARS);


            $em = $this->getDoctrine()->getManager();
            $pida = $em->getRepository("AppBundle:AdscripcionPida")->findOneById($id);
            $em->remove($pida);
            $em->flush();




            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success'
            ));

            return $response;


        }

    }



    /**
     * @Route("/ajax/finalizar/pida", name="ajax_finalizar_pida")
     * @Method({"POST"})
     */
    public function finalizarPidaAction(Request $request){

        if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $id = filter_input(INPUT_POST, 'finalizar',  FILTER_SANITIZE_SPECIAL_CHARS);


            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository("AppBundle:DocenteServicio")->findOneById($id);
            $servicio->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(4));
            $em->persist($servicio);
            $em->flush();




            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success'
            ));

            return $response;


        }

    }




    
    
    /**
     * @Route("/ajax/eliminar_tutor", name="ajax_eliminar_tutor")
     * @Method({"POST"})
     */
     public function eliminarTutorAction(Request $request){
         
       if($request->isXmlHttpRequest()){
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);
           
            $eliminar = filter_input(INPUT_POST, 'eliminar', FILTER_SANITIZE_SPECIAL_CHARS);
            $ascensoId = filter_input(INPUT_POST, 'ascensoId', FILTER_SANITIZE_SPECIAL_CHARS);
            


           $quitarJurado = $this->getDoctrine()->getRepository("AppBundle:AscensoTutores")->findOneById($eliminar);

           if (!$quitarJurado) {
               throw $this->createNotFoundException('no se encontró el jurado solicitado');
           }
            
            
            
            
            $em = $this->getDoctrine()->getManager();
           $em->remove($quitarJurado);
           $em->flush();
            
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
                'jurados' => $quitarJurado,
                'ascenso'  => $ascensoId
            ));
            
            return $response;
            
            
       }
        
    }
    
}
