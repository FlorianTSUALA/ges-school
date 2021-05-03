<?php

namespace App\Model;

use Core\Model\Model;
use App\Model\Activite;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class PrixAbonnement extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const MONTANT = "montant";
    const PERIODE = "periode"; // ENUM JOUR / MOIS / SEMAINE / ANNEE
    const TYPE_ABONNEMENT = "type_abonnement"; // ENUM ACTVITE / CANTINE
    const TYPE_ABONNEMENT_ID = "type_abonnement_id";


    public function __construct(){
        parent::__construct();
        
        $type_abonnements = Activite::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        array_push($type_abonnements, array('id' => 0, 'value' => 'Cantine'));
        // $periode = array(['id' => 'JOUR', 'value' => 'Jour'], ['id' => 'SEMAINE', 'value' => 'Semaine'], ['id' => 'MOIS', 'value' => 'Mois'], ['id' => 'ANNEE', 'value' => 'Année']);
        $periode = array(['id' => 'JOUR', 'value' => 'Jour'], ['id' => 'SEMAINE', 'value' => 'Semaine'], ['id' => 'MOIS', 'value' => 'Mois']);
        
        $this->fillables =
            [
                new FormModel(true, self::TYPE_ABONNEMENT_ID, 'Motif', InputType::SELECT2, $type_abonnements, '', 'Choisir un motif', true, 'select2 form-control'),
                new FormModel(true, self::PERIODE,  self::PERIODE, InputType::SELECT2, $periode, '', 'Choisir une periode', true, 'select2 form-control'),
                new FormModel(true, self::MONTANT,'Montant',InputType::NUMBER ),
                //new FormModel(true, self::TYPE_ABONNEMENT,'type d\'activité' ),
                //new FormModel(true, self::DESCRIPTION ), // INSEERTION DU TYPE D ACTVITE OU UN BREF RESUME
            ];

    }
}