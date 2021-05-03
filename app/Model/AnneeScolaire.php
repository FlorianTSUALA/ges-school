<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class AnneeScolaire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const SLOGAN = "slogan";
    const MISSION = "mission";
    const DEBUT_ANNEE = "debut_annee";
    const FIN_ANNEE = "fin_annee";
    const STATUT = "statut";

    public function __construct(){
        parent::__construct();
        $this->fillables = 
        [
            new FormModel(true, self::LIBELLE, self::LIBELLE, InputType::TEXT, [], '2019-2020' ),
            new FormModel(true, self::DEBUT_ANNEE, 'Début d\'année', InputType::DATE),
            new FormModel(true, self::FIN_ANNEE, 'Fin d\'année', InputType::DATE),
            new FormModel(true, self::STATUT, self::STATUT, InputType::RADIO, [['id'=>'1', 'value'=>'Actif'], ['id'=>'0', 'value'=>'Inactif']]),
            new FormModel(true, self::SLOGAN, self::SLOGAN, InputType::TEXT, [], '', '', false),
            new FormModel(true, self::MISSION, self::MISSION, InputType::TEXT, [], '', '', false),
        ];
    }


}