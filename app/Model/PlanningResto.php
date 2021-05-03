<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class PlanningResto extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const ABONNEMENT_ID = "abonnement_id";
    const DATE_PONTUELLLE = "date_pontuellle";
    const DATE_DEBUT = "date_debut";
    const DATE_FIN = "date_fin";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false, 'abonnement','Abonnement' ),
                new FormModel(true, self::DATE_PONTUELLLE , 'Date pontuellle', InputType::DATE),
                new FormModel(true, self::DATE_DEBUT ,'Date de debut',InputType::DATE ),
                new FormModel(true, self::DATE_FIN ,'Date de fin',InputType::DATE ),

            ];

    }
}