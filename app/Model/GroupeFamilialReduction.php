<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\Model\HydrahonModel;

class GroupeFamilialReduction extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const ANNEE_SCOLAIRE_ID = 'annee_scolaire_id';
    const GROUPE_FAMILIAL_ID = 'groupe_familial_id';
    const ELEVE_ID = 'eleve_id';
    const FACTURE_ID = 'facture_id';
    const MONTANT = 'montant';
    
    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::ANNEE_SCOLAIRE_ID),
                new FormModel(true, self::GROUPE_FAMILIAL_ID),
                new FormModel(true, self::ELEVE_ID),
                new FormModel(true, self::FACTURE_ID),
                new FormModel(true, self::MONTANT),
            ];
    }
}