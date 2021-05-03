<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class TrancheHoraire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    const TEMPS_DEBUT = "temps_debut";
    const TEMPS_FIN = "temps_fin";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE ),
                new FormModel(true, self::TEMPS_DEBUT , 'Heure de debut', InputType::TIME),
                new FormModel(true, self::TEMPS_FIN ,'Heure de fin',InputType::TIME ),
            ];

    }
}