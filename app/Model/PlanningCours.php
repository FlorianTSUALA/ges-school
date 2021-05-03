<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class PlanningCours extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const Classe_ID = "classe_id";
    const MATIERE_ID = "matiere_id";
    const COURS_ID = "cours_id";
    const TRANCHE_HORAIRE_ID = "tranche_horaire_id";
    const JOURNEE = "journee";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false, 'class','Classe'),
                new FormModel(false, 'matiere','Matière'),
                new FormModel(false, 'cours','Cours'),
                new FormModel(false, 'tranche_horaire','Tranche horaire'),
                new FormModel(true, self::JOURNEE,'journee',InputType::DATE ),
            ];

    }
}