<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OfertaAcademica;
use AppBundle\Form\OfertaAcademicaType;

/**
 * OfertaAcademica controller.
 *
 * @Route("/ceapp/gestion/oferta_academica")
 */
class OfertaAcademicaController extends Controller
{
    /**
     * Lists all OfertaAcademica entities.
     *
     * @Route("/", name="oferta_academica_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ofertaAcademicas = $em->getRepository('AppBundle:OfertaAcademica')->findAll();

        return $this->render('ofertaacademica/index.html.twig', array(
            'ofertaAcademicas' => $ofertaAcademicas,
        ));
    }

    /**
     * Creates a new OfertaAcademica entity.
     *
     * @Route("/new", name="ceapp_gestion_oferta_academica_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ofertaAcademica = new OfertaAcademica();
        $form = $this->createForm('AppBundle\Form\OfertaAcademicaType', $ofertaAcademica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ofertaAcademica);
            $em->flush();

            return $this->redirectToRoute('ceapp_gestion_oferta_academica_show', array('id' => $ofertaAcademica->getId()));
        }

        return $this->render('ofertaacademica/new.html.twig', array(
            'ofertaAcademica' => $ofertaAcademica,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OfertaAcademica entity.
     *
     * @Route("/{id}", name="ceapp_gestion_oferta_academica_show")
     * @Method("GET")
     */
    public function showAction(OfertaAcademica $ofertaAcademica)
    {
        $deleteForm = $this->createDeleteForm($ofertaAcademica);

        return $this->render('ofertaacademica/show.html.twig', array(
            'ofertaAcademica' => $ofertaAcademica,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OfertaAcademica entity.
     *
     * @Route("/{id}/edit", name="ceapp_gestion_oferta_academica_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OfertaAcademica $ofertaAcademica)
    {
        $deleteForm = $this->createDeleteForm($ofertaAcademica);
        $editForm = $this->createForm('AppBundle\Form\OfertaAcademicaType', $ofertaAcademica);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ofertaAcademica);
            $em->flush();

            return $this->redirectToRoute('ceapp_gestion_oferta_academica_edit', array('id' => $ofertaAcademica->getId()));
        }

        return $this->render('ofertaacademica/edit.html.twig', array(
            'ofertaAcademica' => $ofertaAcademica,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OfertaAcademica entity.
     *
     * @Route("/{id}", name="ceapp_gestion_oferta_academica_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OfertaAcademica $ofertaAcademica)
    {
        $form = $this->createDeleteForm($ofertaAcademica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ofertaAcademica);
            $em->flush();
        }

        return $this->redirectToRoute('ceapp_gestion_oferta_academica_index');
    }

    /**
     * Creates a form to delete a OfertaAcademica entity.
     *
     * @param OfertaAcademica $ofertaAcademica The OfertaAcademica entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OfertaAcademica $ofertaAcademica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ceapp_gestion_oferta_academica_delete', array('id' => $ofertaAcademica->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
