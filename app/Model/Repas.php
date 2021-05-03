<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Repas extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    // const POINT_MARCHAND_ID = "point_marchand_id";
    // const NUMERO = "numero";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                // new FormModel(false, 'point_marchand','Point marchand' ),
                // new FormModel(true, self::NUMERO , 'Numéro', InputType::NUMBER),
                new FormModel(true, self::LIBELLE ),
                new FormModel(true, self::DESCRIPTION, 'Description', null, null, null, null, false ),
            ];

    }
}