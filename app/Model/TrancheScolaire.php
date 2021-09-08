<?php

namespace App\Model;

use App\Model\Mois;
use Core\Model\Model;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use Core\HTML\Form\FormModel;        

class TrancheScolaire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    const ANNEE_SCOLAIRE_ID = "annee_scolaire_id";
    const TYPE_TRANCHE_SCOLAIRE_ID = "type_tranche_scolaire_id";
    const MOIS = 'mois';
    const DATE_LIMITE_PAIEMENT = 'date_limite_paiement';
    const DATE_DEBUT = "date_debut";
    const DATE_FIN = "date_fin";

    public function __construct(){
        parent::__construct();
        $anneeScolaires = AnneeScolaire::table(DBTable::ANNEE_SCOLAIRE)
                            ->select([ AnneeScolaire::CODE.' as id', AnneeScolaire::LIBELLE.' as value'])
                            ->where('visibilite', 1)
                            ->orderBy('date_creation', 'desc')
                            ->get();
        $type_tranche_scolaires = TypeTrancheScolaire::table()
                            ->select([ 
                              'code' => 'id', 
                              'libelle' => 'value']
                              )
                            ->where('visibilite', 1)
                            ->orderBy('date_creation', 'desc')
                            ->get();
        $mois = Mois::table()->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();
                            
        $this->fillables =
            [
                new FormModel(false, self::TYPE_TRANCHE_SCOLAIRE_ID, 'Type de tranche', InputType::SELECT2, $type_tranche_scolaires, '', 
                         'Veuillez selectionnez un type de tranche scolaire', true, 'select2', '', '', '', TypeTrancheScolaire::LIBELLE),
                new FormModel(true, self::LIBELLE, "Tranche"),
                new FormModel(false, self::DESCRIPTION, "Mois concerné(s)", InputType::SELECT2_MULTIPLE, $mois, 'Ex: mois de la tranche(Janvier, Fé...)' , true, 'select2 multiple', '', '', '', DBTable::TRANCHE_SCOLAIRE, Self::DESCRIPTION), //"#SELECT2MULTIPLE"
                // new FormModel(false, self::ANNEE_SCOLAIRE_ID, 'Année scolaire', InputType::SELECT2, $anneeScolaires, '', 
                //          'Veuillez selectionnez une année scolaire', true, 'select2', '', '', '', AnneeScolaire::LIBELLE),
                new FormModel(true, self::DATE_LIMITE_PAIEMENT, 'Date de limite de paiement', InputType::DATE),
                // new FormModel(true, self::DATE_DEBUT , 'Date de début', InputType::DATE),
                // new FormModel(true, self::DATE_FIN ,'Date de fin',InputType::DATE ),
            ];

    }
}