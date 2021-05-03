<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Composer extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const ClASSE_ID = "classe_Id";
    const MATIERE_ID = "matiere_id";
    const COURS_ID = "cours_id";
    const ELEVE_ID = "eleve_id";
    const PERIODE_ID = "periode_id";
    const PERSONNEL_ID = "personnel_id";
    const NOTE = "note";
    const MENTION = "mention";

    public function __construct(){
        parent::__construct();
        $this->fillables =
        [
            new FormModel(true,'classe','Classe'),
            new FormModel(true,'matiere','Matière'),
            new FormModel(true,'cours','Cours'),
            new FormModel(true,'eleve','Elève'),
            new FormModel(true,'periode','Période'),
            new FormModel(true,'personnel','Personnel'),
            new FormModel(true,self::NOTE,'Note', InputType::NUMBER),
            new FormModel(true,self::MENTION),
        ];
    }
}