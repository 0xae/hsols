<?php
namespace Admin\Backend\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Admin\Backend\Entity\Model;
use Admin\Backend\Entity\Stage;
use Admin\Backend\Entity\Order;
use Admin\Backend\Model\ExportDataExcel;

class DefaultController extends Controller {
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $fotos = $em->getRepository('BackendBundle:Upload')
                    ->findBy(['reference' => 'user_'.$userId]);
        $photo = false;

        foreach ($fotos as $f) {
            $photo = $f->getFilename();
        }

        if ($photo) {
            $user = $em->getRepository('BackendBundle:User')->find($userId);
            $user->setPhotoDir($photo);
            $em->persist($user);       
            $em->flush();
        }

        $template='BackendBundle:Home:dashboard.html.twig';
        $pending = ['status' => Order::PENDING];
        $sent = ['status'=>Order::SENT];

        // hotel user 
        if ($this->getUser()->getProfile()->getId() == 2) {
            $template='BackendBundle:Home:dashboard-client.html.twig';
            $pending['createdBy']=$this->getUser()->getId();
            $sent['createdBy']=$pending['createdBy'];
        }

        $counters = [
            'product_count' => $this->count('product')[0]['count'],
            'pending_orders' => $this->count('order_', $pending)[0]['count'],
            'sent_orders' => $this->count('order_', $sent)[0]['count']
        ];

        $orders = $this->container
            ->get('sga.admin.filter')
            ->from($em, Order::class, 10, 0, $pending)
            ->getResult();

        return $this->render($template, array(
            "counters" => $counters,
            "orders" => $orders
        ));
    }

    private function count($model, $opts=[]) {
        $q = '
            select
                count(1) as count
            from ' . $model . '
            where year(created_at) = year(current_date)
                and month(created_at) = month(current_date) 
        ';

        $params = [];

        if (@$opts['status']) {
            $q .= ' and status=:status ';
            $params['status']=$opts['status'];
        }

        if (@$opts['createdBy']) {
            $q .= ' and created_by=:createdBy ';
            $params['createdBy']=$opts['createdBy'];
        }

        return $this->fetchAll($q, $params);
    }

    private function fetchAll($sql, $params) {
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

}
