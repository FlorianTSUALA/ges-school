<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use Core\HTML\Form\FormModel;        

class TypePension extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const PAIEMENT_EN_TRANCHE = "paiement_en_tranche";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE ),
                // new FormModel(true, self::CODE ,'Code', InputType::TEXT, ),
                new FormModel(true, self::DESCRIPTION ),
                new FormModel(true, self::PAIEMENT_EN_TRANCHE, 'Paiement en tranche ?', InputType::RADIO, [['id'=>'Oui', 'value'=>'Oui'], ['id'=>'Non', 'value'=>'Non']]),

            ];
    }

    
    /**
     * BLOCK CONSTANT FOR NON EDITABLE ENTRY IN DATABASE
     */
    const INSCRIPTION_CODE = "INSCRIPTION";
    const SCOLARITE_CODE = "SCOLARITE";

}