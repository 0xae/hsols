<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\Backend\Entity\ImplMeasure;
use Admin\Backend\Form\ImplMeasureType;

/**
 * ImplMeasure controller.
 *
 */
class ImplMeasureController extends Controller
{

    /**
     * Lists all ImplMeasure entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $pageIdx = !array_key_exists('page', $_GET) ? 1 : $_GET['page'];
        $perPage = 10;

        $q = $this->container
            ->get('sga.admin.filter')
            ->from($em, ImplMeasure::class, $perPage, ($pageIdx-1)*$perPage);

        $fanta = $this->container
            ->get('sga.admin.table.pagination')
            ->fromQuery($q, $perPage, $pageIdx);

        $entities = $q->getResult();         

        return $this->render('BackendBundle:ImplMeasure:index.html.twig', array(
            'entities' => $entities,
            'paginate' => $fanta
        ));
    }
    /**
     * Creates a new ImplMeasure entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ImplMeasure();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userId = $this->getUser();
            $entity->setCreatedBy($userId);
            $entity->setCreatedAt(new \DateTime);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administration_ImplMeasure_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:ImplMeasure:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ImplMeasure entity.
     *
     * @param ImplMeasure $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ImplMeasure $entity)
    {
        $form = $this->createForm(new ImplMeasureType(), $entity, array(
            'action' => $this->generateUrl('administration_ImplMeasure_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ImplMeasure entity.
     *
     */
    public function newAction()
    {
        $entity = new ImplMeasure();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:ImplMeasure:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ImplMeasure entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ImplMeasure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImplMeasure entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ImplMeasure:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ImplMeasure entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ImplMeasure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImplMeasure entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ImplMeasure:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ImplMeasure entity.
    *
    * @param ImplMeasure $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ImplMeasure $entity)
    {
        $form = $this->createForm(new ImplMeasureType(), $entity, array(
            'action' => $this->generateUrl('administration_ImplMeasure_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ImplMeasure entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ImplMeasure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImplMeasure entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_ImplMeasure_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:ImplMeasure:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ImplMeasure entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:ImplMeasure')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ImplMeasure entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administration_ImplMeasure'));
    }

    /**
     * Creates a form to delete a ImplMeasure entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_ImplMeasure_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
