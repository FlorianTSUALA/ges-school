<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Reservation extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const ELEVE_ID = "eleve_id";
    const DOCUMENT_ID = "document_id";
    const DATE_RESERVATION = "date_reservation";
    const COMMENTAIRE = "commentaire";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false,'eleve','Elève'),
                new FormModel(false,'document','Document'),
                new FormModel(true, self::DATE_RESERVATION ,'Date de réservation',InputType::DATE ),
                new FormModel(true, self::COMMENTAIRE ),

            ];

    }
}
