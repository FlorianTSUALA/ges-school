<?php

namespace App\Model;

use App\Model\Eleve;
use Core\Model\Model;
use App\Model\AnneeScolaire;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use Core\HTML\Form\FormModel;        

class GroupeFamilial extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const REFENCE = 'reference';
    const FAMILLE = 'famille';
    
    public function __construct(){
        parent::__construct();

        $anneeScolaires = AnneeScolaire::table(DBTable::ANNEE_SCOLAIRE) ->select([ AnneeScolaire::CODE => 'id', AnneeScolaire::LIBELLE => 'value'])
                                                                        ->where('visibilite', 1)
                                                                        ->get();

        // $type_tranche_scolaires = TypeTrancheScolaire::table()  ->select([ 'code' => 'id', 'libelle' => 'value'])
        //                                                         ->where('visibilite', 1)
        //                                                         ->get();

        // $eleves = Eleve::table()->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();
                                                                      
        $this->fillables =
            [
                new FormModel(true, self::REFENCE),
                new FormModel(true, self::FAMILLE),
                // new FormModel(false, self::DESCRIPTION, "Elève(s) concerné(s)", InputType::SELECT2_MULTIPLE, $eleves, '' , true, 'select2 multiple', '', '', '', DBTable::GROUPE_FAMILIAL, Self::DESCRIPTION), //"#SELECT2MULTIPLE"
            ];
    }

}

