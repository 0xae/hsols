<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\Backend\Entity\Correction;
use Admin\Backend\Form\CorrectionType;

/**
 * Correction controller.
 *
 */
class CorrectionController extends Controller {
    /**
     * Lists all Correction entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $pageIdx = !array_key_exists('page', $_GET) ? 1 : $_GET['page'];
        $perPage = 10;

        $q = $this->container
            ->get('sga.admin.filter')
            ->from($em, Correction::class, $perPage, ($pageIdx-1)*$perPage);

        $fanta = $this->container
            ->get('sga.admin.table.pagination')
            ->fromQuery($q, $perPage, $pageIdx);

        $entities = $q->getResult();         

        return $this->render('BackendBundle:Correction:index.html.twig', array(
            'entities' => $entities,
            'paginate' => $fanta
        ));
    }
    /**
     * Creates a new Correction entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Correction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userId = $this->getUser();
            $entity->setCreatedBy($userId);
            $entity->setCreatedAt(new \DateTime);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administration_Correction_edit', 
                    array('id' => $entity->getId(),
                          'is_new' => true))
                );
        }

        return $this->render('BackendBundle:Correction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Correction entity.
     *
     * @param Correction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Correction $entity)
    {
        $form = $this->createForm(new CorrectionType(), $entity, array(
            'action' => $this->generateUrl('administration_Correction_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Correction entity.
     *
     */
    public function newAction()
    {
        $entity = new Correction();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:Correction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Correction entity.
     *
     */
    public function showAction($id)
    {
        return $this->redirect(
            $this->generateUrl('administration_Correction_edit', 
            array('id' => $id))
        );
        // $em = $this->getDoctrine()->getManager();

        // $entity = $em->getRepository('BackendBundle:Correction')->find($id);

        // if (!$entity) {
        //     throw $this->createNotFoundException('Unable to find Correction entity.');
        // }

        // $deleteForm = $this->createDeleteForm($id);

        // return $this->render('BackendBundle:Correction:show.html.twig', array(
        //     'entity'      => $entity,
        //     'delete_form' => $deleteForm->createView(),
        // ));
    }

    /**
     * Displays a form to edit an existing Correction entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Correction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Correction entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Correction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Correction entity.
    *
    * @param Correction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Correction $entity)
    {
        $form = $this->createForm(new CorrectionType(), $entity, array(
            'action' => $this->generateUrl('administration_Correction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Correction entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Correction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Correction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_Correction_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Correction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Correction entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Correction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Correction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administration_Correction'));
    }

    /**
     * Creates a form to delete a Correction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_Correction_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
