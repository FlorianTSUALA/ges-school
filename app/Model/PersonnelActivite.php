<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use ClanCats\Hydrahon\Query\Expression as Ex;
use Core\Model\HydrahonModel;

class PersonnelActivite extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const ACTICITE_ID = "acticite_id";
    const PERSONNEL_ID = "personnel_id";
    const POURCENTAGE = "pourcentage";
    const MONTANT = "montant";

    public function __construct(){
        parent::__construct();
        $personnels = Personnel::table()->select([ 'code' => 'id' , new Ex("concat(personnel.nom,' ',personnel.prenom) as libelle"),])->where('visibilite', 1)->get();
        $activites = Activite::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $this->fillables =
        [
            new FormModel(false,'activite_id','Activite', InputType::SELECT2, $activites, '', 'Choisir une activité', true, 'select2 form-control'),
            new FormModel(false,'personnel_id','Personnel', InputType::SELECT2, $personnels, '', 'Choisir un personnel', true, 'select2 form-control'),
            new FormModel(true, self::POURCENTAGE, self::POURCENTAGE, InputType::NUMBER, [], '', '', false),
            new FormModel(true, self::MONTANT, self::MONTANT, InputType::NUMBER, [], '', '', false),
            new FormModel(true, self::LIBELLE, 'Libellé', InputType::TEXT, [], '', '', false),
            new FormModel(true, self::DESCRIPTION,  self::DESCRIPTION, InputType::TEXT, [], '', '', false ),
        ];


    }
}