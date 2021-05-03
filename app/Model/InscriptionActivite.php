<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use ClanCats\Hydrahon\Query\Expression as Ex;
use Core\Model\HydrahonModel;

class InscriptionActivite extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const ELEVE_ID = "eleve_id";
    const PERSONNEL_ACTIVITE_ID = "personnel_activite_id";
    const DATE_INSCRIPTION = "date_inscription";
    const DATE_ARRET = "date_arret";
    const MONTANT = "montant";

    public function __construct(){
        parent::__construct();
        $eleves = Eleve::table()->select([ 'code' => 'id' , new Ex("concat(eleve.nom,' ',eleve.prenom) as libelle"),])->where('visibilite', 1)->get();
        $personel_activites = PersonnelActivite::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $this->fillables =
        [
            new FormModel(false,self::ELEVE_ID,'Eleve', InputType::SELECT2, $eleves, '', 'Choisir un eleve', true, 'select2 form-control'),
            new FormModel(false,self::PERSONNEL_ACTIVITE_ID,'Activité suivie', InputType::SELECT2, $personel_activites, '', 'Choisir une activité', true, 'select2 form-control'),
            new FormModel(true, self::DATE_INSCRIPTION, "Date d'inscription", InputType::DATE, [], '', '', false),
            new FormModel(true, self::DATE_ARRET, "Date d'arret", InputType::DATE, [], '', '', false),
            new FormModel(true, self::MONTANT, self::MONTANT, InputType::NUMBER, [], '', '', false),
            new FormModel(true, self::LIBELLE, 'Libellé', InputType::TEXT, [], '', '', false),
            new FormModel(true, self::DESCRIPTION,  self::DESCRIPTION, InputType::TEXT, [], '', '', false ),
        ];


    }
}