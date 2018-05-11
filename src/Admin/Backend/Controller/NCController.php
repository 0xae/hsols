<?php
namespace Admin\Backend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\Backend\Entity\User;
use Admin\Backend\Form\UserType;
use Admin\Backend\Entity\Profile;
use Admin\Backend\Form\ProfileType;
use Admin\Backend\Entity\UserProfile;
use Admin\Backend\Form\UserProfileType;
use Admin\Backend\Model\Settings;
use Admin\Backend\Entity\Stage;
use Admin\Backend\Entity\ProfilePermission;

/**
 * Admin controller.
 */
class NCController extends Controller {
    public function indexAction() {
        return $this->render('BackendBundle:NC:index.html.twig', array(            
        ));
    }

    public function searchAction() {
        $em = $this->getDoctrine()->getManager();
        $type = $_GET['type'];

        $results = $this->container
            ->get('sga.admin.filter')
            ->ByState($em, $type, Stage::NO_CONFOR)[0];

        $ary = [];

        foreach($results as $r) {
            $ary[] = [
                "id" => $r->getId(),
                "code" => $r->getObjCode(),
                "date" => $r->getCreatedAt()->format(Settings::DATE_FMT),
                "resp_date" => $r->getRespDate()->format(Settings::DATE_FMT),
                "created_at" => $r->getCreatedAt()->format(Settings::DATE_FMT),
                "created_by" => $r->getCreatedBy()->getName() . '/' . $r->getCreatedBy()->getEntity()->getName()
            ];
        }

        return new JsonResponse($ary);
    }
}
