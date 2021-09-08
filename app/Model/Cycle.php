<?php

namespace App\Model;

use App\Model\Classe;
use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Cycle extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const CLASSE_FIN_CYCLE = 'classe_fin_cycle';

    
    public function __construct(){
        parent::__construct();

        $classes = Classe::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE ),
                new FormModel(false, self::CLASSE_FIN_CYCLE, 'Classe de fin de cycle', InputType::SELECT2, $classes, '', 'Choisir une classe', false, 'select2 form-control', '',  'classe_fin_cycle', 'classe', 'libelle'),
                new FormModel(true, self::DESCRIPTION, self::DESCRIPTION, InputType::TEXT, [], '', '', false),
            ];
    }
}