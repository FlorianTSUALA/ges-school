<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class TypePaiement extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE ),
            ];
    }

    const CODE_MOBILE_MONEY = "MOBILE_MONEY";
    const CODE_CHEQUE = "CHEQUE";
    const CODE_ESPECE = "ESPECE";
    
}