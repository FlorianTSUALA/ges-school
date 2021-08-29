<?php

namespace App\Model;

use App\Model\Mois;
use Core\Model\Model;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;
use Core\HTML\Form\FormModel;        

class TrancheScolaireMois extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    const TRANCHE_SCOLAIRE_ID = "tranche_scolaire_id";
    const MOIS_ID = 'mois_id';

    public function __construct(){
        parent::__construct();
    }
}