<?php

namespace App\Model;

use App\Model\Eleve;
use Core\Model\Model;
use App\Model\AnneeScolaire;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use Core\HTML\Form\FormModel;        
use ClanCats\Hydrahon\Query\Expression;

class GroupeFamilial extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const REFENCE = 'reference';
    const FAMILLE = 'famille';
    
    public function __construct(){
        parent::__construct();

        // $eleves = Eleve::table()->select([ 'code' => 'id' , new Expression("concat(nom,' ',prenom) as value")])->whereNull('groupe_familial_id')->where('visibilite', 1)->get();
        $eleves = Eleve::table()->select([ 'code' => 'id' , new Expression("concat(nom,' ',prenom) as value")])->where('visibilite', 1)->get();
                            
        $this->fillables =
            [
                new FormModel(true, self::FAMILLE),
                new FormModel(false, self::DESCRIPTION, "Membre(s) de la familial ", InputType::SELECT2_MULTIPLE, $eleves, 'Membres de la famille' , true, 'select2 multiple', '', '', '', DBTable::GROUPE_FAMILIAL, Self::DESCRIPTION), //"#SELECT2MULTIPLE"
            ];
    }

}

