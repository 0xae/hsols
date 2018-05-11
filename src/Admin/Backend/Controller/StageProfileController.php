<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\Backend\Entity\StageProfile;
use Admin\Backend\Form\StageProfileType;

/**
 * StageProfile controller.
 *
 */
class StageProfileController extends Controller
{

    /**
     * Lists all StageProfile entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:StageProfile')->findAll();

        return $this->render('BackendBundle:StageProfile:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new StageProfile entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new StageProfile();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administration_StageProfile_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:StageProfile:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a StageProfile entity.
     *
     * @param StageProfile $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(StageProfile $entity)
    {
        $form = $this->createForm(new StageProfileType(), $entity, array(
            'action' => $this->generateUrl('administration_StageProfile_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new StageProfile entity.
     *
     */
    public function newAction()
    {
        $entity = new StageProfile();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:StageProfile:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a StageProfile entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:StageProfile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StageProfile entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:StageProfile:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing StageProfile entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:StageProfile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StageProfile entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:StageProfile:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a StageProfile entity.
    *
    * @param StageProfile $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(StageProfile $entity)
    {
        $form = $this->createForm(new StageProfileType(), $entity, array(
            'action' => $this->generateUrl('administration_StageProfile_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing StageProfile entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:StageProfile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StageProfile entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_StageProfile_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:StageProfile:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a StageProfile entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:StageProfile')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StageProfile entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administration_StageProfile'));
    }

    /**
     * Creates a form to delete a StageProfile entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_StageProfile_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
