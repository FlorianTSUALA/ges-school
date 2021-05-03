<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use ClanCats\Hydrahon\Query\Expression as Ex;
use Core\Model\HydrahonModel;

class Cours extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const ClASSE_ID = "classe_Id";
    const SALLE_ClASSE_ID = "salle_classe_Id";
    const MATIERE_ID = "matiere_id";
    const PERSONNEL_ID = "personnel_id";
    const VOLUME_HORAIRE = "volume_horaire";
    const COEFFICIENT = "coefficient";

    public function __construct(){
        parent::__construct();
        $classes = Classe::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $salle_classes = SalleClasse::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $matieres =  Matiere::table()->select([ 'code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();
        $personnels = Personnel::table()->select([ 'code' => 'id' , new Ex("concat(nom,' ',prenom) as value")])->where('visibilite', 1)->get();

        $this->fillables =
        [
            new FormModel(true, self::LIBELLE, 'Libellé' ),
            new FormModel(false, self::ClASSE_ID, 'Classe', InputType::SELECT2, $classes, '', 'Choisir une classe', true, 'select2 form-control'),
            new FormModel(false, self::SALLE_ClASSE_ID, 'Salle Classe', InputType::SELECT2, $salle_classes, '', 'Choisir une salle de classe', true, 'select2 form-control'),
            new FormModel(false, self::MATIERE_ID, 'Matière', InputType::SELECT2, $matieres, '', 'Choisir une matiere', true, 'select2 form-control'),
            new FormModel(false, self::PERSONNEL_ID, 'Personnel', InputType::SELECT2, $personnels, '', 'Choisir un personnel', true, 'select2 form-control'),
            new FormModel(true,self::VOLUME_HORAIRE,'Volume horaire', InputType::NUMBER),
            new FormModel(true,self::COEFFICIENT,'Coefficient', InputType::NUMBER),

        ];
    }
}