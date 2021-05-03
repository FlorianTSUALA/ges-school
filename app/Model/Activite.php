<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Activite extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const TYPE_ACTIVITE_ID = "type_activite_id";
    const MONTANT = "montant";

    public function __construct(){
        parent::__construct();
        $type_activites = TypeActivite::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();

        $this->fillables =
            [
                new FormModel(false,self::TYPE_ACTIVITE_ID, 'Type d\'activite', InputType::SELECT2, $type_activites, '', 'Choisir un type d\'activité', true, 'select2 form-control'),
                new FormModel(true, self::LIBELLE, self::LIBELLE, InputType::TEXT, [], '', '', false),
                new FormModel(true, self::MONTANT, self::MONTANT, InputType::NUMBER, [], '', '', false),
                new FormModel(true, self::DESCRIPTION, self::DESCRIPTION, InputType::TEXT, [], '', '', false),
            ];
    }
}