<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Model\DBTable;
use App\Controller\Admin\AppController;

class EtatDocumentController extends AppController
{
    
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::ETAT_DOCUMENT;
        $this->folder_view_index = 'etat_document.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'etat_document';
        $this->class_name = 'etat_document';

        $this->title_page = 'Gestion des état du document - Ges-School';
        $this->title_home = 'Gestion des état du document';
        $this->create_title = "Création d'un état du document";
        $this->view_title = "Information d'un état du document";
        $this->update_title = "Mise à jour d'un état du document";
        $this->delete_title = "Suppression d'un état du document";
        $this->msg_delete = "Voulez-vous vraiment supprimer cet état du document? ";
        
    }

    }
    