<?php
namespace Admin\Twig;

use Admin\Backend\Model\Settings;
use Admin\Backend\Model\Stage;

class StatusExtension extends \Twig_Extension {
    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('status', array($this, 'statusFilter'))
        );
    }

    public function statusFilter($status) {
        if ($status == 'acompanhamento') {
            return 'Acompanhamento';
        } else if ($status == 'tratamento') {
            return 'Tratamento';
        } else if ($status == 'aceitado') {
            return 'Aceite';
        } else if ($status == 'rejeitado') {
            return 'Rejeitado';
        } else if ($status == 'respondido') {
            return 'Respondido';
        } else if ($status == 'sem_resposta') {
            return 'Sem resposta';
        } else if ($status == 'favoravel') {
            return 'Favoravel';
        } else if ($status == 'nao_favoravel') {
            return 'Não favoravel';           
        } else if ($status == 'sem_competencia') {
            return 'Competência de terceiros';            
        } else if ($status == 'nao_conformidade') {            
            return 'Não Conformidades';
        } else if ($status == 'analysis') {
            return 'Análise';
        } else if ($status == 'action') {
            return 'Ação';
        } else if ($status == 'decision') {
            return 'Decisão';
        } else if ($status == 'concluded') {
            return 'Concluida';
        } else {
            return $status;
        }
    }
}
