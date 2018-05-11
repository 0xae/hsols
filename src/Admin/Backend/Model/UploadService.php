<?php
namespace Admin\Backend\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UploadService {
    public function __construct(Container $container) {    
        $this->container = $container;
    } 

    public function fetch($reference) {
    }    
}