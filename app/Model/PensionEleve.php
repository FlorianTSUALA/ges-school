<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class PensionEleve extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const TYPE_PENSION_ID = "type_pension_id";
    const Classe_ID = "classe_id";
    const PensionClasse_ID = "pension_classe_id";
    const ELEVE_ID = "eleve_id";
    // const TYPE_PAIEMENT_ID = "type_paiement_id";
    const TRANCHE_SCOLAIRE_ID = "tranche_scolaire_id";
    // const LIBELLE = "libelle";
    const MOTIF = "motif";
    const MONTANT = "montant";
    const QUANTITE = "quantite";
    // const MOIS = "mois";
    // const DATE_PAIEMENT = "date_paiement";
    // const RESTE = "reste";
    const REDUCTION = "reduction";
    // const AUTRES = "autres";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false, 'type_pension','Type de pension'),
                new FormModel(false, 'classe', 'Classe'),
                new FormModel(false, 'pension_classe','Pension'),
                new FormModel(false, 'eleve','Elève'),
                new FormModel(false, 'type_paiement','Type de paiement'),
                new FormModel(false, 'tranche_scolaire', 'Tranche scolaire'),
                new FormModel(true, self::LIBELLE),
                new FormModel(true, self::MOTIF ),
                new FormModel(true, self::MONTANT,'Montant',InputType::NUMBER ),
                new FormModel(true, self::QUANTITE , 'Quantite', InputType::NUMBER),
                // new FormModel(true, self::MOIS ,'Mois',InputType::DATE ),
                // new FormModel(true, self::DATE_PAIEMENT ,'Date de paie',InputType::DATE ),
                // new FormModel(true, self::RESTE ,'Reste',InputType::NUMBER ),
                new FormModel(true, self::REDUCTION , 'Réduction', InputType::NUMBER),
                // new FormModel(true, self::AUTRES ),
            ];

    }
}