<?php 

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Emprunt extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const ELEVE_ID = "eleve_id";
    const ETAT_DOCUMENT_ID = "etat_document_id";
    const EXEMPLAIRE_ID = "exemplaire_id";
    const RESTITUTION_ID = "restitution_id";
    const STATUT = "statut";
    const DATE_EMPRUNT = "date_emprunt";
    const DATE_EXPIRATION = "date_expiration";

    public function __construct(){
        parent::__construct();

        $samples = ['RESTITUE','EMPRUNTE'];

        $this->fillables =
            [
                new FormModel(false, self::ELEVE_ID, 'Elève', InputType::SELECT2, $samples, '', 'Choisir l\'emprunteur', true, 'select2 form-control'),
                new FormModel(false, self::EXEMPLAIRE_ID, 'Titre', InputType::SELECT2, $samples, '', 'Choisir un document', true, 'select2 form-control'),
                new FormModel(true, self::DATE_EMPRUNT , 'Date d\'emprunt', InputType::DATE),
                new FormModel(true, self::DATE_EXPIRATION ,'Date d\'expiration',InputType::DATE ),
            ];
    }

    public static function getColumns()        
    {
        $columns = '';
        $columns .= '{ "data": "id" },';
        $columns .= '{ "data": "num" },';
        $columns .= '{ "data": "code_enregistrement" },';
        $columns .= '{ "data": "titre" },';
        $columns .= '{ "data": "eleve" },';
        $columns .= '{ "data": "date_emprunt" },';
        $columns .= '{ "data": "date_expiration" },';
        $columns .= '{ "data": "classe" },';
        $columns .= '{ "data": "etat_document" },';
        $columns .= '{ "data": null }';
        return $columns;
    }
}