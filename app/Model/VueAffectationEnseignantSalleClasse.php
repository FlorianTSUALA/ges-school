<?php

namespace App\Model;

use Core\Model\Model;
use App\Model\Personnel;
use App\Model\SalleClasse;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use App\Repository\AffectationSalleClasseRepository;

class VueAffectationEnseignantSalleClasse extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const ENSEIGNANT = "enseignant";
    const SALLE_CLASSE_ID = "salle_classe_id";
    
    public function __construct(){
        parent::__construct();
        
        $enseignants = ( new AffectationSalleClasseRepository() )->getEnseignantNonAffecte();
        $salle_classe = SalleClasse::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        
        $this->fillables =
            [
                new FormModel(false, self::ENSEIGNANT,'Type de personnel', InputType::SELECT2, $enseignants, '', 'Choisir un type de personnel', true, 'select2 form-control'),
                new FormModel(false, self::SALLE_CLASSE_ID,'Salle_classe d\'origine', InputType::SELECT2, $salle_classe, '', 'Choisir un salle_classe', true, 'select2 form-control'),
            
            ];

    }
}