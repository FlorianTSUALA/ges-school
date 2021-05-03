<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use ClanCats\Hydrahon\Query\Expression as Ex;
        
use Core\Model\HydrahonModel;

class AffectationPersonnelSalleClasse extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const PERSONNEL_ID = "personnel_id";
    const CLASSE_MATIERE_ID = "classe_matiere_id";
    
    public function __construct(){
        parent::__construct();
        
        // $classes = Classe::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        // $matieres =  Matiere::table()->select([ 'code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();

        $this->fillables =
            [
              // new FormModel(true, 'coefficient','Coefficient'),      
              // new FormModel(false,'classe_id','Classe', InputType::SELECT2, $classes, '', 'Choisir une classe', true, 'select2 form-control'),
              // new FormModel(false, 'matiere_id', 'Matière', InputType::SELECT2, $matieres, '', 'Choisir une matiere', true, 'select2 form-control'),
            ];
    }
}