<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use Core\HTML\Form\FormModel;        

class Pays extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE),
                new FormModel(true, self::DESCRIPTION, self::DESCRIPTION, InputType::TEXT, [], '', '', false),
            ];
    }
}