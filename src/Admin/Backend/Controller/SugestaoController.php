<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\Backend\Entity\Sugestao;
use Admin\Backend\Form\SugestaoType;

/**
 * Sugestao controller.
 *
 */
class SugestaoController extends Controller
{

    /**
     * Lists all Sugestao entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Sugestao')->findAll();

        return $this->render('BackendBundle:Sugestao:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Sugestao entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Sugestao();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administration_sugestao_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:Sugestao:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Sugestao entity.
     *
     * @param Sugestao $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Sugestao $entity)
    {
        $form = $this->createForm(new SugestaoType(), $entity, array(
            'action' => $this->generateUrl('administration_sugestao_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Salvar'));

        return $form;
    }

    /**
     * Displays a form to create a new Sugestao entity.
     *
     */
    public function newAction()
    {
        $entity = new Sugestao();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:Sugestao:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Sugestao entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Sugestao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sugestao entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Sugestao:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sugestao entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Sugestao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sugestao entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Sugestao:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Sugestao entity.
    *
    * @param Sugestao $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Sugestao $entity)
    {
        $form = $this->createForm(new SugestaoType(), $entity, array(
            'action' => $this->generateUrl('administration_sugestao_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Atualizar'));

        return $form;
    }
    /**
     * Edits an existing Sugestao entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Sugestao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sugestao entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_sugestao_edit', array('id' => $id)));
        }

        $this->addFlash("success", "Sugestao code 1 atualizada com sucesso.");

        return $this->render('BackendBundle:Sugestao:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Sugestao entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Sugestao')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sugestao entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administration_sugestao'));
    }

    /**
     * Creates a form to delete a Sugestao entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_sugestao_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
