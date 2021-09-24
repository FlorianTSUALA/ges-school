<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Model\DBTable;
use App\Controller\Admin\AppController;

class MoisController extends AppController
{
    
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::MOIS;
        $this->folder_view_index = 'mois.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'mois';
        $this->class_name = 'mois';

        $this->title_page = 'Gestion des mois - ' . $this->organisation;
        $this->title_home = 'Gestion des mois';
        $this->create_title = "Création d'un mois";
        $this->view_title = "Information d'un mois";
        $this->update_title = "Mise à jour d'un mois";
        $this->delete_title = "Suppression d'un mois";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce mois? ";
        
    }



        
}
    