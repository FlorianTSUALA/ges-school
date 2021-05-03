<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use ClanCats\Hydrahon\Query\Expression as Ex;
        
use Core\Model\HydrahonModel;

class AffectationClasseMatiere extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const CLASSE_ID = "classe_id";
    const MATIERE_ID = "matiere_id";
    const COFFICIENT = "coefficient";

    
    public function __construct(){
        parent::__construct();
        $classes = Classe::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $matieres =  Matiere::table()->select([ 'code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();


        $this->fillables =
            [
              new FormModel(true, 'coefficient','Coefficient'),      
              new FormModel(false,'classe_id','Classe', InputType::SELECT2, $classes, '', 'Choisir une classe', true, 'select2 form-control'),
              new FormModel(false, 'matiere_id', 'Matière', InputType::SELECT2, $matieres, '', 'Choisir une matiere', true, 'select2 form-control'),

              //new FormModel(false,'classe_id','Classe', InputType::SELECT2, $classes, '', 'Choisir une classe', true, 'select2 form-control'),
            

            ];
    }
}