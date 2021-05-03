<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Model\Document;
use App\Helpers\TraitCRUDController;

use function Core\Helper\dd;
use App\Controller\Admin\AppController;

class DocumentController extends AppController
{
    use TraitCRUDController;
   
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::DOCUMENT;
        $this->folder_view_index = 'document.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'document';
        $this->class_name = 'Document';

        $this->title_page = 'Gestion des documents - Ges-School';
        $this->title_home = 'Gestion des documents';
        $this->create_title = "Creation d'un document";
        $this->view_title = "Information d'un document";
        $this->update_title = "Mise à jour d'un document";
        $this->delete_title = "Suppression d'un document";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce document ";
    }

    public function getall(){
        $model = Document::table();
        $results = $model->select('
                domaine.libelle as domaine_id, 
                domaine.code as external_target,
                document.code as code, 
                document.'.Document::TITRE.' as '.Document::TITRE.', 
                document.'.Document::NUMERO_ISBN.' as '.Document::NUMERO_ISBN.', 
                document.'.Document::AUTEUR.' as '.Document::AUTEUR.', 
                document.'.Document::NOMBRE_PAGE.' as '.Document::NOMBRE_PAGE.',
                document.'.Document::MAISON_EDITION.' as '.Document::MAISON_EDITION.',
                document.'.Document::DATE_PUBLICATION.' as '.Document::DATE_PUBLICATION.'
                ')
                    ->where('document.visibilite','=', 1)
                    ->join('domaine', 'document.domaine_id', '=', 'domaine.id')
                    ->get();
        // dd($results);
        return $results;
    }

}
