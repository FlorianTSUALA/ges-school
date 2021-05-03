<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class AbonnementCantine extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const ELEVE_ID = "eleve_id";
    const MULTIPLICATEUR = "multiplicateur";
    const DATE_PAIEMENT = "date_paiement";
    const DATE_DEBUT = "date_debut";
    const DATE_FIN = "date_fin";
    const MONTANT = "montant";
    const PERIODE = "periode";

    public function __construct(){        
        parent::__construct();
        $periodes = ['JOUR', 'SEMAINE', 'MOIS', 'ANNEE'];

        $this->fillables =
            [
                new FormModel(false, 'eleve', 'Elève'),
                new FormModel(true, self::MULTIPLICATEUR, self::MULTIPLICATEUR, InputType::NUMBER),
                new FormModel(true, self::DATE_PAIEMENT, self::DATE_PAIEMENT, InputType::DATE, [], '', '', false),
                new FormModel(true, self::DATE_DEBUT, self::DATE_DEBUT, InputType::DATE, [], '', '', false),
                new FormModel(true, self::DATE_FIN, self::DATE_FIN, InputType::DATE, [], '', '', false),
                new FormModel(true, self::MONTANT, self::MONTANT, InputType::NUMBER, [], '', '', false),
                new FormModel(true, self::PERIODE, self::PERIODE, InputType::SELECT2, $periodes, '', '', false),
                new FormModel(true, self::LIBELLE, 'Libellé', InputType::TEXT, [], '', '', false),
            ];
        
    }
}