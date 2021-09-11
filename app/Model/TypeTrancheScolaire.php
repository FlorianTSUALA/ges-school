<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class TypeTrancheScolaire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const ANNEE_SCOLAIRE_ID = "annee_scolaire_id";


    public function __construct(){
        parent::__construct();
        $annee_scolaires = AnneeScolaire::table(DBTable::ANNEE_SCOLAIRE)
        ->select([ 
            AnneeScolaire::CODE => 'id', 
            AnneeScolaire::LIBELLE => 'value'
            ])
        ->where('visibilite', 1)
        ->orderBy('date_creation', 'desc')
        ->get();

        $this->fillables =
            [
                new FormModel(true, self::LIBELLE ),
                // new FormModel(false, self::ANNEE_SCOLAIRE_ID, 'Année scolaire', InputType::SELECT2, $annee_scolaires, '', 'Veuillez selectionnez une année scolaire'),
            ];

    }

    
}