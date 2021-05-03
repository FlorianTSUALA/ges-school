<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Salaire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const PERSONNEL_ID = "personnel_id";
    const MONTANT = "montant";
    const DATE_PAIEMENT = "date_paiement";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false, 'personnel','Personnel' ),
                new FormModel(true, self::MONTANT , 'Montant', InputType::NUMBER),
                new FormModel(true, self::DATE_PAIEMENT ,'Date de paie',InputType::DATE ),

            ];

    }
}