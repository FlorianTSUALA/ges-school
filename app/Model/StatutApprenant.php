<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\Model\HydrahonModel;

class StatutApprenant extends Model implements FrequentlyReapeat
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

    const CODE_NOUVEAU = 'NOUVEAU';
    const REDOUBLANT_CODE = 'REDOUBLANT';
    const CODE_ANCIEN = 'ANCIEN';

}