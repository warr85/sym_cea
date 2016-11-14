<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
 
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Request;



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
            $posts =  $em->getRepository('AppBundle:DocenteServicio')->findBy(array(
                'idEstatus'    => 2
            ));            
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
    
}
