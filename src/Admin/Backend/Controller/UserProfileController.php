<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\Backend\Entity\UserProfile;
use Admin\Backend\Form\UserProfileType;

/**
 * UserProfile controller.
 *
 */
class UserProfileController extends Controller {
    /**
     * Lists all UserProfile entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BackendBundle:UserProfile')->findAll();

        return $this->render('BackendBundle:UserProfile:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new UserProfile entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new UserProfile();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // $userId = $this->getUser()->getId();
            // $entity->setCreatedBy($userId);

            try {
                $em->persist($entity);
                $em->flush();
            } catch (Exception $e) {
                return new JsonResponse(array(
                    'status' => 400,
                    'msg' => 'verifique todos os campos'
                ));
            }

            // return $this->redirect($this->generateUrl('backend_administration_main', array('tab' => 'assoc')));
            return new JsonResponse(array(
                'status' => 200,
                'object' => [
                    'id' => $entity->getId(),
                    'name' => $entity->getProfile()->getName(),
                    'permission' => $entity->getProfile()->getPermission()
                ]
            ));
        }

        return $this->render('BackendBundle:UserProfile:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new UserProfile entity.
     *
     */
    public function newAction() {
        $entity = new UserProfile();
        $form = $this->createCreateForm($entity);

        return $this->render('BackendBundle:UserProfile:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserProfile entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:UserProfile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfile entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:UserProfile:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserProfile entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:UserProfile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfile entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:UserProfile:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing UserProfile entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:UserProfile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfile entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_UserProfile_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:UserProfile:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserProfile entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:UserProfile')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserProfile entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administration_UserProfile'));
    }

    /**
    * Creates a form to edit a UserProfile entity.
    *
    * @param UserProfile $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UserProfile $entity) {
        $form = $this->createForm(new UserProfileType(), $entity, array(
            'action' => $this->generateUrl('administration_UserProfile_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Creates a form to create a UserProfile entity.
     *
     * @param UserProfile $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserProfile $entity) {
        $form = $this->createForm(new UserProfileType(), $entity, array(
            'action' => $this->generateUrl('administration_UserProfile_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Creates a form to delete a UserProfile entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_UserProfile_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
