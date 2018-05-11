<?php
namespace Admin\Backend;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BackendBundle extends Bundle {
	public function getParent() {
		return 'FOSUserBundle';
	}
}
