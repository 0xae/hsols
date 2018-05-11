<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

use Admin\Backend\Entity\ModuleStage;
use Admin\Backend\Form\ModuleStageType;

/**
 * ModuleStage controller.
 *
 */
class ModuleStageController extends Controller
{

    /**
     * Lists all ModuleStage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:ModuleStage')->findAll();

        return $this->render('BackendBundle:ModuleStage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ModuleStage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ModuleStage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $entity->setCreatedBy($user);
            $entity->setCreatedAt(new \DateTime());

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administration_Module_edit', array('id' => $entity->getModule()->getId())));
        }

        return $this->render('BackendBundle:ModuleStage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ModuleStage entity.
     *
     * @param ModuleStage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ModuleStage $entity)
    {
        $form = $this->createForm(new ModuleStageType(), $entity, array(
            'action' => $this->generateUrl('administration_ModuleStage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ModuleStage entity.
     *
     */
    public function newAction()
    {
        $entity = new ModuleStage();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:ModuleStage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ModuleStage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ModuleStage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuleStage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ModuleStage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ModuleStage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ModuleStage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuleStage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ModuleStage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ModuleStage entity.
    *
    * @param ModuleStage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ModuleStage $entity)
    {
        $form = $this->createForm(new ModuleStageType(), $entity, array(
            'action' => $this->generateUrl('administration_ModuleStage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ModuleStage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ModuleStage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuleStage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_ModuleStage_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:ModuleStage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ModuleStage entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $q = $em->createQuery('update BackendBundle:Sugestion m set m.stage = null where m.stage = ' . $id);
        $q->execute();

        $q = $em->createQuery('update BackendBundle:Complaint m set m.stage = null where m.stage = ' . $id);
        $q->execute();        

        $q = $em->createQuery('update BackendBundle:ModuleStage m set m.stage = null where m.stage = ' . $id);
        $q->execute();

        $entity = $em->getRepository('BackendBundle:ModuleStage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuleStage entity.');
        }

        $c = array('id' => $entity->getModule()->getId());
        
        try {            
            $em->remove($entity);
            $em->flush();
        } catch (ForeignKeyConstraintViolationException $fk) {
            $this->addFlash(
                'ms',
                'A etapa nao pode ser removido pois esta em uso.'
            );
        }
        
        $url = $this->generateUrl('administration_Module_edit', $c);
        return $this->redirect($url);
    }

    /**
     * Creates a form to delete a ModuleStage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_ModuleStage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
