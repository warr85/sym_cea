<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Seccion;
use AppBundle\Form\SeccionType;

/**
 * Seccion controller.
 *
 * @Route("/ceapp/gestion/seccion")
 */
class SeccionController extends Controller
{
    /**
     * Lists all Seccion entities.
     *
     * @Route("/", name="ceapp_gestion_oferta_academica_seccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $seccions = $em->getRepository('AppBundle:Seccion')->findAll();

        return $this->render('seccion/index.html.twig', array(
            'seccions' => $seccions,
        ));
    }

    /**
     * Creates a new Seccion entity.
     *
     * @Route("/new", name="ceapp_gestion_oferta_academica_seccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $seccion = new Seccion();
        $form = $this->createForm('AppBundle\Form\SeccionType', $seccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seccion);
            $em->flush();

            return $this->redirectToRoute('ceapp_gestion_oferta_academica_seccion_show', array('id' => $seccion->getId()));
        }

        return $this->render('seccion/new.html.twig', array(
            'seccion' => $seccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Seccion entity.
     *
     * @Route("/{id}", name="ceapp_gestion_oferta_academica_seccion_show")
     * @Method("GET")
     */
    public function showAction(Seccion $seccion)
    {
        $deleteForm = $this->createDeleteForm($seccion);

        return $this->render('seccion/show.html.twig', array(
            'seccion' => $seccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Seccion entity.
     *
     * @Route("/{id}/edit", name="ceapp_gestion_oferta_academica_seccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Seccion $seccion)
    {
        $deleteForm = $this->createDeleteForm($seccion);
        $editForm = $this->createForm('AppBundle\Form\SeccionType', $seccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seccion);
            $em->flush();

            return $this->redirectToRoute('ceapp_gestion_oferta_academica_seccion_edit', array('id' => $seccion->getId()));
        }

        return $this->render('seccion/edit.html.twig', array(
            'seccion' => $seccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Seccion entity.
     *
     * @Route("/{id}", name="ceapp_gestion_oferta_academica_seccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Seccion $seccion)
    {
        $form = $this->createDeleteForm($seccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($seccion);
            $em->flush();
        }

        return $this->redirectToRoute('ceapp_gestion_oferta_academica_seccion_index');
    }

    /**
     * Creates a form to delete a Seccion entity.
     *
     * @param Seccion $seccion The Seccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Seccion $seccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ceapp_gestion_oferta_academica_seccion_delete', array('id' => $seccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
