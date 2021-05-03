<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class TrancheScolaire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    const ANNEE_SCOLAIRE_ID = "annee_scolaire_id";
    const DATE_DEBUT = "date_debut";
    const DATE_FIN = "date_fin";

    public function __construct(){
        parent::__construct();
        $anneeScolaires = AnneeScolaire::table(DBTable::ANNEE_SCOLAIRE)
                            ->select([ AnneeScolaire::CODE.' as id', AnneeScolaire::LIBELLE.' as value'])
                            ->where('visibilite', 1)
                            ->where('statut', 1)
                            ->orderBy('date_creation', 'desc')
                            ->get();
                            
        $this->fillables =
            [
                new FormModel(false, self::ANNEE_SCOLAIRE_ID, 'Année scolaire', InputType::SELECT2, $anneeScolaires, '', 
                    'Veuillez selectionnez une année scolaire', true, 'select2', '', '', '', AnneeScolaire::LIBELLE),
                new FormModel(true, self::LIBELLE, self::LIBELLE, InputType::SELECT2, 
                [
                   [ 'id' => 'Janvier', 'value' => 'Janvier'], 
                   [ 'id' => 'Février', 'value' => 'Février'], 
                   [ 'id' => 'Mars', 'value' => 'Mars'], 
                   [ 'id' => 'Avril', 'value' => 'Avril'], 
                   [ 'id' => 'Mai', 'value' => 'Mai'], 
                   [ 'id' => 'Juin', 'value' => 'Juin'], 
                   [ 'id' => 'Juillet', 'value' => 'Juillet'], 
                   [ 'id' => 'Août', 'value' => 'Août'], 
                   [ 'id' => 'Septembre', 'value' => 'Septembre'], 
                   [ 'id' => 'Octobre', 'value' => 'Octobre'], 
                   [ 'id' => 'Novembre', 'value' => 'Novembre'], 
                   [ 'id' => 'Decembre', 'value' => 'Decembre'], 
                ], 'Ex: mois de la tranche(Janvier, Fé...)' ),
                // new FormModel(true, self::DATE_DEBUT , 'Date de début', InputType::DATE),
                // new FormModel(true, self::DATE_FIN ,'Date de fin',InputType::DATE ),
            ];

    }
}