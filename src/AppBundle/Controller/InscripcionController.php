<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Inscripcion;
use AppBundle\Form\InscripcionType;

/**
 * Inscripcion controller.
 *
 * @Route("/ceapp/estudiante/inscripcion")
 */
class InscripcionController extends Controller
{
    /**
     * Lists all Inscripcion entities.
     *
     * @Route("/", name="inscripcion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $estado_academico = $em->getRepository('AppBundle:EstadoAcademico')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        
        return $this->render('inscripcion/index.html.twig', array(
            'estado_academico' => $estado_academico
        ));
    }

    /**
     * Creates a new Inscripcion entity.
     *
     * @Route("/new", name="ceapp_estudiante_inscripcion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $inscripcion = $this->getDoctrine()->getRepository('AppBundle:EstadoAcademico')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $form = $this->createForm('AppBundle\Form\InscripcionType', $inscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscripcion);
            $em->flush();

            return $this->redirectToRoute('ceapp_estudiante_inscripcion_show', array('id' => $inscripcion->getId()));
        }

        return $this->render('inscripcion/new.html.twig', array(
            'inscripcion' => $inscripcion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Inscripcion entity.
     *
     * @Route("/{id}", name="ceapp_estudiante_inscripcion_show")
     * @Method("GET")
     */
    public function showAction(Inscripcion $inscripcion)
    {
        $deleteForm = $this->createDeleteForm($inscripcion);

        return $this->render('inscripcion/show.html.twig', array(
            'inscripcion' => $inscripcion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Inscripcion entity.
     *
     * @Route("/{id}/edit", name="ceapp_estudiante_inscripcion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Inscripcion $inscripcion)
    {
        $deleteForm = $this->createDeleteForm($inscripcion);
        $editForm = $this->createForm('AppBundle\Form\InscripcionType', $inscripcion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscripcion);
            $em->flush();

            return $this->redirectToRoute('ceapp_estudiante_inscripcion_edit', array('id' => $inscripcion->getId()));
        }

        return $this->render('inscripcion/edit.html.twig', array(
            'inscripcion' => $inscripcion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Inscripcion entity.
     *
     * @Route("/{id}", name="ceapp_estudiante_inscripcion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Inscripcion $inscripcion)
    {
        $form = $this->createDeleteForm($inscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inscripcion);
            $em->flush();
        }

        return $this->redirectToRoute('ceapp_estudiante_inscripcion_index');
    }

    /**
     * Creates a form to delete a Inscripcion entity.
     *
     * @param Inscripcion $inscripcion The Inscripcion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Inscripcion $inscripcion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ceapp_estudiante_inscripcion_delete', array('id' => $inscripcion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
