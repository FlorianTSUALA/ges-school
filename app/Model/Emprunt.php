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
        $columns .= '{ "data": "idt" },';
        $columns .= '{ "data": "numr" },';
        $columns .= '{ "data": "code_enregistremente" },';
        $columns .= '{ "data": "titrer" },';
        $columns .= '{ "data": "elevet" },';
        $columns .= '{ "data": "date_empruntt" },';
        $columns .= '{ "data": "date_expirationg" },';
        $columns .= '{ "data": "classeg" },';
        $columns .= '{ "data": "etat_documentf" },';
        $columns .= '{ "data": null }';
        return $columns;
    }
}