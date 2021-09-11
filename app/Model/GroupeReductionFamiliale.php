<?php

namespace App\Model;

use App\Model\Eleve;
use Core\Model\Model;
use App\Model\AnneeScolaire;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use Core\HTML\Form\FormModel;        

class GroupeReductionFamiliale extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const ELEVE_ID = 'eleve_id';
    const REDUCTION_FAMILIALE_ID = 'reduction_familiale_id';
    
    public function __construct(){
        parent::__construct();
                                                
        $this->fillables =
            [

            ];
    }

}

