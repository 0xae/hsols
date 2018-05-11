<?php

namespace Admin\Backend\Entity;

use Doctrine\ORM\Mapping as ORM;

class Model {
    const RECLAMATION_INTERNAL = 'reclamacao_interna';
    const RECLAMATION_EXTERN = 'reclamacao';
    const SUGESTION = 'sugestao';
    const COMPLAINT = 'queixa';
    const DENOUNCE = 'denuncia';
    const COMP_BOOK= 'comp_book';
}
