<?php
namespace Admin\Backend\Model;

use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Symfony\Component\DependencyInjection\ContainerInterface as Container,
    Pagerfanta\Exception\NotValidCurrentPageException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Pagination {
    public function __construct(Container $container) {    
        $this->container = $container;
    } 
    
    /**
     * $q is an instance of Query
     */
    public function fromQuery($q, $perPage, $page) {
        $fanta = new PagerFanta(new DoctrineORMAdapter($q));

        try {
            $fanta->setMaxPerPage($perPage);
            if ($page != 0)
                $fanta->setCurrentPage($page);
        } catch(NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $fanta;        
    }
}