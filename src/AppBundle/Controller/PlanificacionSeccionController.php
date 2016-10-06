<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\PlanificacionSeccion;
use AppBundle\Form\PlanificacionSeccionType;
use AppBundle\Entity\Seccion;
/**
 * PlanificacionSeccion controller.
 *
 * @Route("/ceapp/docente/planificacion")
 */
class PlanificacionSeccionController extends Controller
{
    /**
     * Lists all PlanificacionSeccion entities.
     *
     * @Route("/", name="ceapp_docente_planificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $secciones = $em->getRepository('AppBundle:Seccion')->findBy(array(
           'idRolInstitucion' => $this->getUser()->getIdRolInstitucion() 
        ));
        $planificacionSeccions = $em->getRepository('AppBundle:PlanificacionSeccion')->findAll();

        return $this->render('planificacionseccion/index.html.twig', array(
            'planificacionSeccions' => $planificacionSeccions,
            'secciones'             => $secciones
        ));
    }

    /**
     * Creates a new PlanificacionSeccion entity.
     *
     * @Route("/new/{seccion}", name="ceapp_docente_planificacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Seccion $seccion)
    {
        $em = $this->getDoctrine()->getManager();
        $planificacionSeccion = new PlanificacionSeccion();  
        $planificacion = $em->getRepository('AppBundle:PlanificacionSeccion')->findBySeccion($seccion);
        //var_dump($planificacion->getIdtemaUc()->getId()); exit;
        $form = $this->createForm('AppBundle\Form\PlanificacionSeccionType', $planificacionSeccion, array(
            'seccion' => $seccion,
            'planificacion' => $planificacion
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            
            
            $seccion->addPlanificacion($planificacionSeccion);
            
            // ciclo a traves de las relaciones para cada contenido añadirle la planificacion
            foreach($planificacionSeccion->getContenido() as $contenido){
                $contenido->setPlanificacionSeccionId($planificacionSeccion);                
            }
            
            foreach($planificacionSeccion->getObjetivoEspecifico() as $especifico){
                $especifico->setPlanificacionSeccionId($planificacionSeccion);              
            }
            
            foreach ($planificacionSeccion->getEstrategia() as $estrategias){
                $estrategias->setPlanificacionSeccionId($planificacionSeccion);                                  
            }
            
            foreach ($planificacionSeccion->getEvaluacion() as $evaluaciones){
                $evaluaciones->setPlanificacionSeccionId($planificacionSeccion);                                  
            }
                                              
            //var_dump($seccion->getPlanificacion()->count()); exit;
            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacionSeccion);
            //$em->persist($seccion);
            $em->flush();

            return $this->redirectToRoute('ceapp_docente_planificacion_show', array('id' => $planificacionSeccion->getId()));
        }

        return $this->render('planificacionseccion/new.html.twig', array(
            'planificacionSeccion' => $planificacionSeccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PlanificacionSeccion entity.
     *
     * @Route("/show/{id}/{porcentaje}", name="ceapp_docente_planificacion_show")
     * @Method("GET")
     */
    public function showAction(Seccion $seccion, $porcentaje = null)
    {
        $planificacionSeccion = $this->getDoctrine()->getRepository('AppBundle:PlanificacionSeccion')->findBySeccion($seccion);
        //$deleteForm = $this->createDeleteForm($planificacionSeccion);
        
        return $this->render('planificacionseccion/show.html.twig', array(
            'planificacionSeccion' => $planificacionSeccion,
            'porcentaje'            => $porcentaje
        ));
    }

    /**
     * Displays a form to edit an existing PlanificacionSeccion entity.
     *
     * @Route("/{id}/edit", name="ceapp_docente_planificacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PlanificacionSeccion $planificacionSeccion)
    {
        $seccion = $this->getDoctrine()->getRepository('AppBundle:Seccion')->findOneById($planificacionSeccion->getSeccion());
        $deleteForm = $this->createDeleteForm($planificacionSeccion);
        $editForm = $this->createForm('AppBundle\Form\PlanificacionSeccionType', $planificacionSeccion, array('seccion' => $seccion));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacionSeccion);
            $em->flush();

            return $this->redirectToRoute('ceapp_docente_planificacion_edit', array('id' => $planificacionSeccion->getId()));
        }

        return $this->render('planificacionseccion/edit.html.twig', array(
            'planificacionSeccion' => $planificacionSeccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PlanificacionSeccion entity.
     *
     * @Route("/{id}", name="ceapp_docente_planificacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PlanificacionSeccion $planificacionSeccion)
    {
        $form = $this->createDeleteForm($planificacionSeccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planificacionSeccion);
            $em->flush();
        }

        return $this->redirectToRoute('ceapp_docente_planificacion_index');
    }

    /**
     * Creates a form to delete a PlanificacionSeccion entity.
     *
     * @param PlanificacionSeccion $planificacionSeccion The PlanificacionSeccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PlanificacionSeccion $planificacionSeccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ceapp_docente_planificacion_delete', array('id' => $planificacionSeccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
