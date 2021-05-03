<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class SalleClasse extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const CLASSE_ID = "classe_id";

    public function __construct(){
        parent::__construct();
        $classes = Classe::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $this->fillables =
        [
            new FormModel(false,'classe_id','Classe', InputType::SELECT2, $classes, '', 'Choisir une classe', true, 'select2 form-control'),
            new FormModel(true, self::LIBELLE, 'Libellé' ),
            new FormModel(true, self::DESCRIPTION,  self::DESCRIPTION, InputType::TEXT, [], '', '', false ),
        ];


    }
}