<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Restitution extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const EMPRUNT_ID = "emprunt_id";
    const EXEMPLAIRE_ID = "exemplaire_id";
    const DATE_RESTITUTION = "date_restitution";
    const COMMENTAIRE = "commentaire";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false, self::EMPRUNT_ID,'Emprunt' ),
                new FormModel(true, self::DATE_RESTITUTION , 'Date de restitution', InputType::DATE),
                new FormModel(true, self::COMMENTAIRE, 'Commentaire', InputType::TEXT, [], '', '', false),

            ];

    }
}