<?php

namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\Backend\Entity\Upload;
use Admin\Backend\Form\UploadType;

use Admin\Backend\Entity\Product;
use Admin\Backend\Entity\Category;
use Admin\Backend\Form\ProductType;

/**
 * Product controller.
 *
 */
class ProductController extends Controller {
    /**
     * Lists all Product entities.
     *
     */
    public function indexAction() {
        $this->checkAccess();
        $em = $this->getDoctrine()->getManager();
        $pageIdx = !array_key_exists('page', $_GET) ? 1 : $_GET['page'];
        $perPage = 10;

        $q = $this->container
            ->get('sga.admin.filter')
            ->from($em, Product::class, $perPage, ($pageIdx-1)*$perPage);

        $fanta = $this->container
            ->get('sga.admin.table.pagination')
            ->fromQuery($q, $perPage, $pageIdx);

        $entities = $q->getResult();         

        return $this->render('BackendBundle:Product:index.html.twig', array(
            'entities' => $entities,
            'paginate' => $fanta,
            'categories' => $em->getRepository('BackendBundle:Category')->findAll()
        ));
    }

    /**
     * Lists all Product entities.
     *
     */
    public function catalogAction() {
        $em = $this->getDoctrine()->getManager();
        $pageIdx = !array_key_exists('page', $_GET) ? 1 : $_GET['page'];
        $perPage = 10;
        $filterCat=1;

        $params = [];
        if (@$_GET['category']) {
            $params['category']=$_GET['category'];
            $filterCat=$_GET['category'];
        }

        $q = $this->container
            ->get('sga.admin.filter')
            ->from($em, Product::class, $perPage, ($pageIdx-1)*$perPage, $params);

        $fanta = $this->container
            ->get('sga.admin.table.pagination')
            ->fromQuery($q, $perPage, $pageIdx);

        $entities = $q->getResult();
        foreach ($entities as $ent) {
            $pic = $em->getRepository('BackendBundle:Upload')->findBy([
                'reference' => $ent->getAnnexReference()
            ]);

            if ($pic) {
                $ent->setPicture($pic[0]->getFilename());
            }
        } 

        return $this->render('BackendBundle:Product:catalog.html.twig', array(
            'entities' => $entities,
            'paginate' => $fanta,
            'categoryFilter' => $filterCat,
            'categories' => $em->getRepository('BackendBundle:Category')->findAll()
        ));
    }

    /**
     * Creates a new Product entity.
     *
     */
    public function createAction(Request $request) {
        $this->checkAccess();
        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userId = $this->getUser();
            $entity->setCreatedBy($userId);
            $entity->setCreatedAt(new \DateTime);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administration_Product_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'upload_form' => $upload_form
        ));
    }

    private function checkAccess() {
        if ($this->getUser()->getProfile()->getId() != 1) {
            throw new Exception("Acess denied");
        }
    }

    /**
     * Creates a form to create a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Product $entity) {
        $entity->setAnnexReference(md5(uniqid()));
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('administration_Product_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Displays a form to create a new Product entity.
     *
     */
    public function newAction() {
        $this->checkAccess();
        $entity = new Product();
        $form = $this->createCreateForm($entity);

        return $this->render('BackendBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'upload_form' => $this->uploadForm($entity)
        ));
    }

    private function uploadForm($model) {
        $entity = new Upload();
        $entity->setReference($model->getAnnexReference());

        return $this->createForm(new UploadType(), $entity, array(
            'action' => $this->generateUrl('administration_Upload_create'),
            'method' => 'POST',
        ))->createView();
    }

    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Product:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     */
    public function editAction($id) {
        $this->checkAccess();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Product:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'upload_form' => $this->uploadForm($entity),
        ));
    }

    /**
    * Creates a form to edit a Product entity.
    *
    * @param Product $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Product $entity) {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('administration_Product_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Product entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $this->checkAccess();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administration_Product_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Product:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $this->checkAccess();
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administration_Product'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_Product_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
