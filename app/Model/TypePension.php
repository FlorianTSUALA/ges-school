<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\Model\HydrahonModel;

class TypePension extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE ),
                // new FormModel(true, self::CODE ,'Code', InputType::TEXT, ),
                new FormModel(true, self::DESCRIPTION ),
            ];
    }

    
    /**
     * BLOCK CONSTANT FOR NON EDITABLE ENTRY IN DATABASE
     */
    const INSCRIPTION_CODE = "INSCRIPTION";
    const SCOLARITE_CODE = "SCOLARITE";

}