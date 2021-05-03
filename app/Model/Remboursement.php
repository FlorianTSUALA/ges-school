<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Remboursement extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const PERSONNEL_ID = "personnel_id";
    const DETTE_ID = "dette_id";
    const MOTIF = "motif";
    const MONTANT = "montant";
    const DATE_REMBOURSEMENT = "date_remboursement";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false, 'personnel','Personnel'),
                new FormModel(false, 'dette','Dette'),
                new FormModel(true, self::MOTIF),
                new FormModel(true, self::MONTANT ,'Montant',InputType::NUMBER ),
                new FormModel(true, self::DATE_REMBOURSEMENT ,'Date de remboursement',InputType::DATE ),

            ];

    }
}
