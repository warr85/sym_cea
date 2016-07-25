<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Inscripcion;
use AppBundle\Entity\EstadoAcademico;


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
        $ea = $this->getDoctrine()->getRepository('AppBundle:EstadoAcademico')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $oferta = $this->getDoctrine()->getRepository('AppBundle:OfertaAcademica')->findBy(
            array('idOfertaMallaCurricular'   =>  $ea->getIdOfertaMallaCurricular()),
            array('idMallaCurricularUc' => 'ASC')
        );
        
        $seccion = $this->getDoctrine()->getRepository('AppBundle:Seccion')->findAll();
        

        $form = $this->createForm('AppBundle\Form\InscripcionType', $ea, array('inscripcion' => $ea,));
        $form->handleRequest($request);

        if ($request->isMethod("POST")) {
            //var_dump($request->request->get('seccion')['idSeccion']); exit;
            $em = $this->getDoctrine()->getManager();
            
            foreach ($request->request->get('seccion')['idSeccion'] as $s ){
                $inscripcion = $this->getDoctrine()->getRepository('AppBundle:Seccion')->findOneById($s);
                //var_dump($inscripcion->getId()); exit;
                $ea->setIdSeccion($inscripcion);
            };            
            $em->persist($ea);
            $em->flush();

            return $this->redirectToRoute('inscripcion_index');
        }

        return $this->render('inscripcion/new.html.twig', array(
            'estado_academico'  => $ea,
            'oferta'       => $oferta,
            'seccion'       => $seccion,
            'form'          => $form->createView()
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
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($inscripcion);
        $estado_academico = $em->getRepository('AppBundle:EstadoAcademico')->findOneByIdRolInstitucion($this->getUser()->getIdRolInstitucion());
        $editForm = $this->createForm('AppBundle\Form\InscripcionEditType', $inscripcion, array('oferta' => $inscripcion->getIdSeccion()->getOfertaAcademica()->getId()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
           // $em = $this->getDoctrine()->getManager();
            $em->persist($estado_academico);
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

        return $this->redirectToRoute('inscripcion_index');
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
