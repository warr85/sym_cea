<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\PlanificacionCalificacion;
use AppBundle\Entity\PlanificacionSeccion;
use AppBundle\Form\PlanificacionCalificacionType;
use AppBundle\Entity\Seccion;

/**
 * PlanificacionCalificacion controller.
 *
 * @Route("/ceapp/docente/calificar")
 */
class PlanificacionCalificacionController extends Controller
{
    /**
     * Lists all PlanificacionCalificacion entities.
     *
     * @Route("/", name="ceapp_docente_calificar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $planificacionCalificacions = $em->getRepository('AppBundle:PlanificacionCalificacion')->findAll();

        return $this->render('planificacioncalificacion/index.html.twig', array(
            'planificacionCalificacions' => $planificacionCalificacions,
        ));
    }

    /**
     * Creates a new PlanificacionCalificacion entity.
     *
     * @Route("/new/{planificacion}", name="ceapp_docente_calificar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, PlanificacionSeccion $planificacion)
    {
         $planificacionCalificacion = new PlanificacionCalificacion();
        
        if ($request->isMethod("POST")) {
            $em = $this->getDoctrine()->getManager();
            //var_dump($request->request->get('planificacion_calificacion')); exit;
            foreach ($request->request->get('planificacion_calificacion')['idInscripcion'] as $key => $value ){
                
                
                $insertar = explode("_", $key);
                
                if($insertar[0] == 'inscripcion'){
                    $planificacionCalificacion = new PlanificacionCalificacion();                    
                    $idInscripcion = $em->getRepository('AppBundle:Inscripcion')->findOneById($value);
                    $planificacionCalificacion->setIdInscripcion($idInscripcion);
                }else if ($insertar[0] == 'calificacion'){
                    $cal = $value;                    
                }else if ($insertar[0] == 'porcentaje'){
                    $idCalificacion = $em->getRepository('AppBundle:Calificacion')->findOneBy(array(
                        'idNota'    => $cal,
                        'idPorcentaje' => $value
                    ));
                    $planificacionCalificacion->setIdCalificacion($idCalificacion);
                    $planificacionCalificacion->setIdEstatusNota($em->getRepository('AppBundle:EstatusNota')->findOneById(1));
                    $planificacionCalificacion->setIdPlanificacionSeccion($planificacion);
                    $em->persist($planificacionCalificacion);
                    $em->flush();
                }
                
               
            }
            
            
            

            return $this->redirectToRoute('ceapp_docente_calificar_show', array('id' => $planificacionCalificacion->getId()));
        }

        return $this->render('planificacioncalificacion/new.html.twig', array(            
            'planificacion' => $planificacion,            
        ));
    }

    /**
     * Finds and displays a PlanificacionCalificacion entity.
     *
     * @Route("/{id}", name="ceapp_docente_calificar_show")
     * @Method("GET")
     */
    public function showAction(PlanificacionCalificacion $planificacionCalificacion)
    {
        $deleteForm = $this->createDeleteForm($planificacionCalificacion);

        return $this->render('planificacioncalificacion/show.html.twig', array(
            'planificacionCalificacion' => $planificacionCalificacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PlanificacionCalificacion entity.
     *
     * @Route("/{id}/edit", name="ceapp_docente_calificar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PlanificacionCalificacion $planificacionCalificacion)
    {
        $deleteForm = $this->createDeleteForm($planificacionCalificacion);
        $editForm = $this->createForm('AppBundle\Form\PlanificacionCalificacionType', $planificacionCalificacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacionCalificacion);
            $em->flush();

            return $this->redirectToRoute('ceapp_docente_calificar_edit', array('id' => $planificacionCalificacion->getId()));
        }

        return $this->render('planificacioncalificacion/edit.html.twig', array(
            'planificacionCalificacion' => $planificacionCalificacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PlanificacionCalificacion entity.
     *
     * @Route("/{id}", name="ceapp_docente_calificar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PlanificacionCalificacion $planificacionCalificacion)
    {
        $form = $this->createDeleteForm($planificacionCalificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planificacionCalificacion);
            $em->flush();
        }

        return $this->redirectToRoute('ceapp_docente_calificar_index');
    }

    /**
     * Creates a form to delete a PlanificacionCalificacion entity.
     *
     * @param PlanificacionCalificacion $planificacionCalificacion The PlanificacionCalificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PlanificacionCalificacion $planificacionCalificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ceapp_docente_calificar_delete', array('id' => $planificacionCalificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
