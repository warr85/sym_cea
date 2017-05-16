<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 09:08 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\DocumentosVerificados;
use AppBundle\Entity\PidaCaducidad;
use AppBundle\Entity\PidaEstatus;
use AppBundle\Entity\PidaTareaEspecifico;
use AppBundle\Form\PidaTareaEspecificoType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

class PermisosController extends Controller
{
    /**
     * @Route("/solicitud/permisos", name="permisos_index")
     */
    public function permisosIndexAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $docente = $this->getUser()->getIdRolInstitucion();
        $escalafones = $em->getRepository("AppBundle:DocenteEscala")->findOneBy(array(
            'idRolInstitucion' => $docente,
            'idEscala' => $em->getRepository("AppBundle:Escalafones")->findOneById(2)
        ));

        if(!$escalafones){
            $this->addFlash('danger', 'Estimado Docente, debe ser mínimo Asistente para poder realizar esta solicitud');
            return $this->redirect($this->generateUrl('permisos_index'));
        }


        /* Permiso sabatico */
        $sabatico = $this->getDoctrine()->getRepository("AppBundle:DocenteServicio")->findOneBy(array(
            'idRolInstitucion' => $docente, 'idServicioCe'  => 8 ),
            array('id' => 'DESC')
        );

        if($sabatico && ($sabatico->getIdEstatus()->getId() == 1 || $sabatico->getIdEstatus()->getId() == 2 )){
            $tiempoEspera = $sabatico->getFechaSolicitud()->diff(new \DateTime("now"));
            if($tiempoEspera->y >= 7 && $sabatico->getIdEstatus()->getId() == 1){
                $sabatico->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(4));
                $em->persist($sabatico);
                $em->flush();
            }else {
                $this->addFlash('warning', 'Ya posee una solicitud en espera o activa, no puede realizar otra solicitud.');
                return $this->redirect($this->generateUrl('servicios_index'));
            }
        }


        $formSabatico = $this->createForm('AppBundle\Form\PermisoSabaticoType');
        $formSabatico->handleRequest($request);
        if ($formSabatico->isSubmitted() && $formSabatico->isValid()) {

            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(8));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));
            $em->persist($servicios);
            $em->flush();

            $motivo = $formSabatico->get('motivo')->getData();
            $nombreMotivo = md5(uniqid()).'.'.$motivo->guessExtension();

            $motivo->move(
                $this->container->getParameter('permiso_directory'),
                $nombreMotivo
            );
            thumbnail3($nombreMotivo, $this->container->getParameter('permiso_directory'), $this->container->getParameter('permiso_thumb_directory'));

            verificar_documentos3($servicios->getIdRolInstitucion(),18,2,$em,$nombreMotivo, $servicios);
            $this->addFlash('success', 'Permiso solicitado satisfactoriamente');
            return $this->redirect($this->generateUrl('servicios_index'));
        }

        /* Fin Sabatico */





        /* Permiso Estudio */
        $estudio = $this->getDoctrine()->getRepository("AppBundle:DocenteServicio")->findOneBy(array(
            'idRolInstitucion' => $docente, 'idServicioCe'  => 9 ),
            array('id' => 'DESC')
        );

        if($estudio && ($estudio->getIdEstatus()->getId() == 1 || $estudio->getIdEstatus()->getId() == 2 )){
            $tiempoEspera = $estudio->getFechaSolicitud()->diff(new \DateTime("now"));
            if($tiempoEspera->y >= 1 && $estudio->getIdEstatus()->getId() == 1){
                $estudio->setIdEstatus($this->getDoctrine()->getRepository("AppBundle:Estatus")->findOneById(4));
                $em->persist($estudio);
                $em->flush();
            }else {
                $this->addFlash('warning', 'Ya posee una solicitud en espera o activa, no puede realizar otra solicitud.');
                return $this->redirect($this->generateUrl('servicios_index'));
            }
        }


        $formSabatico = $this->createForm('AppBundle\Form\PermisoSabaticoType');
        $formSabatico->handleRequest($request);
        if ($formSabatico->isSubmitted() && $formSabatico->isValid()) {

            $servicios = new DocenteServicio();

            $servicios->setIdRolInstitucion($this->getUser()->getIdRolInstitucion());
            $servicios->setIdServicioCe($this->getDoctrine()->getRepository('AppBundle:ServiciosCe')->findOneById(8));
            $servicios->setIdEstatus($this->getDoctrine()->getRepository('AppBundle:estatus')->findOneById(2));
            $em->persist($servicios);
            $em->flush();

            $motivo = $formSabatico->get('motivo')->getData();
            $nombreMotivo = md5(uniqid()).'.'.$motivo->guessExtension();

            $motivo->move(
                $this->container->getParameter('permiso_directory'),
                $nombreMotivo
            );
            thumbnail3($nombreMotivo, $this->container->getParameter('permiso_directory'), $this->container->getParameter('permiso_thumb_directory'));

            verificar_documentos3($servicios->getIdRolInstitucion(),18,2,$em, $nombreMotivo, $servicios);
            $this->addFlash('success', 'Permiso solicitado satisfactoriamente');
            return $this->redirect($this->generateUrl('servicios_index'));
        }

        /* Fin Estudio */


        return $this->render('solicitudes/permisos_index.html.twig', array(
            'formSabatico'      => $formSabatico->createView()

        ));
    }






}



function thumbnail3 ($filename, $fuente, $destino){
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



function verificar_documentos3($idRolInstitucion, $tipo, $estatus, $em, $ubicacion="", $servicio = 2){
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