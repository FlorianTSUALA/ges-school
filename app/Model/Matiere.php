<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Matiere extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const DISCIPLINE_ID = "discipline_id";
    const COULEUR = "couleur";
    const ABREVIATION = "abreviation";

    public function __construct(){        
        parent::__construct();
        $disciplines = Discipline::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $this->fillables =
            [
                new FormModel(false, self::DISCIPLINE_ID, 'Discipline', InputType::SELECT2, $disciplines, '', 'Choisir un cycle', true, 'select2 form-control'),
                new FormModel(true, self::LIBELLE ),
                new FormModel(true, self::ABREVIATION,'Abbrévation', null, null, null, null, false ),
                new FormModel(true, self::COULEUR,'Couleur', InputType::COLOR, null, null, null, false ),
                new FormModel(true, self::DESCRIPTION ,'Description', null, null, null, null, false),
            ];
    }
}