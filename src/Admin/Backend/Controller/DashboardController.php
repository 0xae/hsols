<?php

namespace Admin\Backend\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller {
	public function indexAction() {
		return $this->render('BackendBundle:Home:dashboard.html.twig', 
			array()
		);
	}
}
