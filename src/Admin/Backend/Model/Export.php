<?php
namespace Admin\Backend\Model;

use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Symfony\Component\DependencyInjection\ContainerInterface as Container,
    Pagerfanta\Exception\NotValidCurrentPageException;


class Export {
    public function __construct(Container $container) {    
        $this->container = $container;
    }

    public function dumpExcel($klass, $header, $rows, $opts=[]) {
        $page=1;
        $perPage=10;
        $filename='listagem.xls';

        if (@$opts['page']){
            $page=(int)$opts['page'];
        }
        if (@$opts['perPage']){
            $perPage=(int)$opts['perPage'];
        }
        if (@$opts['filename']){
            $filename=$opts['filename'];
        }

        $exporter = new ExportDataExcel('browser', $filename);
		$exporter->initialize();
        $exporter->addRow($header);

        foreach ($rows as $row) {
            $exporter->addRow($row);
        }

        $exporter->finalize();
		exit();
    }
}
