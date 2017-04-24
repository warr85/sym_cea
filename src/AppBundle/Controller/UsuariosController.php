<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TutoresAscenso;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Usuarios;
use AppBundle\Form\UsuariosType;

/**
 * Usuarios controller.
 *
 * @Route("ceapp/admin/usuarios")
 */
class UsuariosController extends Controller
{
    /**
     * Lists all Usuarios entities.
     *
     * @Route("/", name="admin_usuarios_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:Usuarios')->findAll();

        return $this->render('usuarios/index.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }

    /**
     * Creates a new Usuarios entity.
     *
     * @Route("/new", name="admin_usuarios_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuarios();
        $form = $this->createForm('AppBundle\Form\UsuarioNuevoType', $usuario);
        $form->handleRequest($request);
        $pass = $usuario->getPlainPassword();
        if(!$pass) $usuario->setPlainPassword ("0000");
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($usuario, $usuario->getPlainPassword());
            $usuario->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('admin_usuarios_show', array('id' => $usuario->getId()));
        }

        return $this->render('usuarios/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuarios entity.
     *
     * @Route("/{id}", name="admin_usuarios_show")
     * @Method("GET")
     */
    public function showAction(Usuarios $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuarios/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuarios entity.
     *
     * @Route("/{id}/edit", name="admin_usuarios_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuarios $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AppBundle\Form\UsuariosType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('admin_usuarios_edit', array('id' => $usuario->getId()));
        }

        return $this->render('usuarios/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usuarios entity.
     *
     * @Route("/{id}", name="admin_usuarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuarios $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('admin_usuarios_index');
    }

    /**
     * Creates a form to delete a Usuarios entity.
     *
     * @param Usuarios $usuario The Usuarios entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuarios $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_usuarios_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }




    /**
     * Lists all Usuarios entities.
     *
     * @Route("/jurados/", name="admin_jurados_index")
     * @Method("GET")
     */
    public function indexJuradosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:TutoresAscenso')->findAll();

        return $this->render('usuarios/jurados_index.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }


    /**
     * Displays a form to edit an existing Usuarios entity.
     *
     * @Route("/jurados/{id}/edit", name="admin_jurados_edit")
     * @Method({"GET", "POST"})
     */
    public function editJuradosAction(Request $request, TutoresAscenso $jurado)
    {
        //$deleteForm = $this->createDeleteForm($jurado);
        $editForm = $this->createForm('AppBundle\Form\TutoresAscensoEditType', $jurado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jurado);
            $em->flush();

            return $this->redirectToRoute('admin_jurados_edit', array('id' => $jurado->getId()));
        }

        return $this->render('usuarios/jurados_edit.html.twig', array(
            'usuario' => $jurado,
            'edit_form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));
    }


}
