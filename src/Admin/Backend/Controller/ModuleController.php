<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\Backend\Entity\Module;
use Admin\Backend\Form\ModuleType;
use Admin\Backend\Entity\ModuleStage;
use Admin\Backend\Form\ModuleStageType;
use Admin\Backend\Entity\StageProfile;
use Admin\Backend\Form\StageProfileType;

/**
 * Module controller.
 *
 */
class ModuleController extends Controller {
    /**
     * Lists all Module entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BackendBundle:Module')->findAll();

        return $this->render('BackendBundle:Module:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Module entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Module();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userId = $this->getUser()->getId();
            $entity->setCreatedBy($userId);
            $entity->setCreatedAt(new \DateTime);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administration_Module_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:Module:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Module entity.
     *
     */
    public function newAction() {
        $entity = new Module();
        $form = $this->createCreateForm($entity);

        return $this->render('BackendBundle:Module:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Module entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Module')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Module entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $stages = $em->getRepository('BackendBundle:ModuleStage')   
                     ->findBy(['module' => $id]);

        return $this->render('BackendBundle:Module:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'stages' => $stages
        ));
    }

    /**
     * Displays a form to edit an existing Module entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Module')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Module entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $stageForm = $this->createStageForm($entity);
        $stageProfileForm = $this->createStageProfileForm($entity);

        $stages = $em->getRepository('BackendBundle:ModuleStage')   
                   ->findBy(['module' => $id]);                

        return $this->render('BackendBundle:Module:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'stage_form' => $stageForm->createView(),
            'stage_profile' => $stageProfileForm->createView(),
            'stages' => $stages
        ));
    }


    /**
     * Edits an existing Module entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Module')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Module entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_Module_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Module:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Module entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Module')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Module entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administration_Module'));
    }

    /**
    * Creates a form to edit a Module entity.
    *
    * @param Module $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Module $entity) {
        $form = $this->createForm(new ModuleType(), $entity, array(
            'action' => $this->generateUrl('administration_Module_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        // $form->add('submit', 'submit', array(
        //     'label' => 'Guardar', 
        //     'attr'=> [
        //         'class' => 'btn btn-success',
        //         'style' => 'margin-top: 25px;'
        //     ])
        // );

        return $form;
    }

    /**
     * Creates a form to create a StageProfile entity.
     *
     * @param StageProfile $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createStageProfileForm($module) {
        $entity = new StageProfile();
        $entity->setModule($module);
        $form = $this->createForm(new StageProfileType(), $entity, array(
            'action' => $this->generateUrl('administration_StageProfile_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Adicionar', 
            'attr'=> [
                'class' => 'btn btn-success',
                'style' => 'margin-top: 25px;'
            ])
        );

        return $form;
    }

    private function createStageForm($module)  {
        $entity = new ModuleStage();
        $entity->setModule($module);

        $form = $this->createForm(new ModuleStageType(), $entity, array(
            'action' => $this->generateUrl('administration_ModuleStage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Adicionar', 
            'attr'=> [
                'class' => 'btn btn-success',
                'style' => 'margin-top: 25px;'
            ])
        );

        return $form;
    }

    /**
     * Creates a form to create a Module entity.
     *
     * @param Module $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Module $entity) {
        $form = $this->createForm(new ModuleType(), $entity, array(
            'action' => $this->generateUrl('administration_Module_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Adicionar', 
            'attr'=> [
                'class' => 'btn btn-success',
                'style' => 'margin-top: 25px;'
            ])
        );

        return $form;
    }

    /**
     * Creates a form to delete a Module entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_Module_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a ModuleStage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createMSDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_ModuleStage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
