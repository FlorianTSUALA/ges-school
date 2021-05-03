<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class AbonnementCantine_old extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const MONTANT = "montant";
    const INSCRIPTION_ID = "inscription_id";
    const ACTIVITE_ID = "activite_id";
    const DATE_PAIEMENT = "date_paiement";
    const DATE_DEBUT = "date_debut";
    const DATE_FIN = "date_fin";
    // const MONTANT = "montant";
    const PERIODE = "periode";
    
    public function __construct(){
        parent::__construct();
        $this->fillables =
        [
            new FormModel(true, self::MONTANT, self::MONTANT, InputType::NUMBER, [], '', '', false),
            new FormModel(true, self::LIBELLE, 'Libellé', InputType::TEXT, [], '', '', false),
        ];


    }
}