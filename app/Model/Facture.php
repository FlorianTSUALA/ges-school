<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\Model\HydrahonModel;

class Facture extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    
    const REFERENCE = "reference";
    const MONTANT = "montant";
    const REDUCTION = "reduction";
    const DATE_FACTURE = "date_facture";
    const BENEFICAIRE = "beneficaire";
    const GESTIONNAIRE = "gestionnaire";
    
    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE),
                new FormModel(true, self::DESCRIPTION),
               //to complete

            ];
    }

    public static function getColumns()        
    {
        $columns = '';
        $columns .= '{ "data": "id" },';
        $columns .= '{ "data": "libelle" },';
        $columns .= '{ "data": "code_enregistrement" },';
        $columns .= '{ "data": "matricule" },';
        $columns .= '{ "data": "date_naissance" },';
        $columns .= '{ "data": "lieu_naissance" },';
        return $columns;
    }
}