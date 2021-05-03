<?php

namespace App\Model;

use Core\Model\Model;
use App\Model\Document;
use App\Model\EnumModel;
use App\Model\EtatDocument;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Exemplaire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const DOCUMENT_ID = "document_id";
    const ETAT_DOCUMENT_ID = "etat_document_id";
    const CODE_ENREGISTRMENT = "code_enregistrement";
    const CODE_BARRE = "code_barre";
    const PRIX = "prix";
    const STATUT = "statut";
    const DATE_ACQUISITION = "date_acquisition";


    public function __construct(){
        parent::__construct();
        //Tenir compte de l'edition du livre et de bien d'autres choses
        $documents = Document::table()->select([ 'code' => 'id' , 'titre' => 'value'])->where('visibilite', 1)->get();
        $etat_documents = EtatDocument::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $status = [
            ['id' => EnumModel::STATUT_DOCUMENT_DISPONIBLE, 'value' => 'Disponible'], 
            ['id' => EnumModel::STATUT_DOCUMENT_NON_DISPONIBLE, 'value' => 'Non disponible'], 
            ['id' => EnumModel::STATUT_DOCUMENT_EMPRUNTE, 'value' => 'Emprunté']
        ];

        $this->fillables =
            [
                new FormModel(false, self::DOCUMENT_ID, 'Document', InputType::SELECT2, $documents, '', 'Choisir un document', true, 'select2 form-control', '', '', '', 'titre'),
                new FormModel(false, self::ETAT_DOCUMENT_ID,'Etat du document', InputType::SELECT2, $etat_documents, '', 'Choisir un état du document', true, 'select2 form-control'),
                new FormModel(true, self::STATUT  ,'Statut du document', InputType::SELECT2, $status, '', 'Choisir un statut', true, 'select2 form-control' ),
                new FormModel(true, self::CODE_ENREGISTRMENT ,'Numero d\'enregistrement', InputType::TEXT ),
                new FormModel(true, self::DATE_ACQUISITION ,'Date d\'acquisition',InputType::DATE ),

            ];
    }

    
}
