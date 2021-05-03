<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class AbonnementConsomme extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const REPAS_ID = "repas_id";
    const JOUR_OUVRABLE_ID = "jour_ouvrable_id";
    const ABONNEMENT_RESTO_ID = "abonnement_resto_id";
    const DATE_EFFECTIVE = "date_effective";

    public function __construct(){
        parent::__construct();
        $repas = [];
        
        $this->fillables =
            [
                new FormModel(false, 'repas', 'Repas', InputType::SELECT2, $repas),
                new FormModel(false, 'jour_ouvrable', 'Jour ouvrable' ),
                new FormModel(false, 'abonnement_resto', 'Abonnement au restaurant'),
                new FormModel(true, self::DATE_EFFECTIVE , 'Date  effective', InputType::DATE),
            ];
    }
}