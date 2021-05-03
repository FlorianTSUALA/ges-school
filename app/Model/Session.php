<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Session extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    const ANNEE_SCOLAIRE_ID = "annee_scolaire_id";
    const DATE_DEBUT = "date_debut";
    const DATE_FIN = "date_fin";

    public function __construct(){
        parent::__construct();
        //TODO AnneeScolaire en cours
        $anneeScolaires = AnneeScolaire::table(DBTable::ANNEE_SCOLAIRE)
        ->select([ AnneeScolaire::CODE.' as id', AnneeScolaire::LIBELLE.' as value'])
        ->where('visibilite', 1)->get();
        
        $this->fillables =
            [
                new FormModel(false, 'annee_scolaire_id','Année scolaire', InputType::SELECT2, $anneeScolaires, '', 
                    'Veuillez selectionnez une année scolaire', true, 'select2', '', '', '', AnneeScolaire::LIBELLE),
                    new FormModel(true, self::LIBELLE , 'Dénomination'),
                    new FormModel(true, self::DATE_DEBUT , 'Date de début', InputType::DATE),
                new FormModel(true, self::DATE_FIN ,'Date de fin',InputType::DATE ),

            ];

    }
}