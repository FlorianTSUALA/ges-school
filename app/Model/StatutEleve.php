<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\Model\HydrahonModel;

class StatutEleve extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity; 
      
    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE ),
                new FormModel(true, self::DESCRIPTION, 'Description', null, null, null, null, false ),

            ];
    }

    const NOUVEAU_CODE = 'NOUVEAU';
    const ANCIEN_CODE = 'ANCIEN';
    const DEMISSINAIRE_CODE = 'DEMISSINAIRE';
    const FIN_CYCLE_CODE = 'FIN_CYCLE';

}