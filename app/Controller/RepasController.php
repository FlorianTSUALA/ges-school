<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Model\DBTable;
use App\Controller\Admin\AppController;

class RepasController extends AppController
{
    
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::REPAS;
        $this->folder_view_index = 'repas.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'repas';
        $this->class_name = 'repas';

        $this->title_page = 'Gestion des repas - Ges-School';
        $this->title_home = 'Gestion des repas';
        $this->create_title = "Creation d'un repas";
        $this->view_title = "Information d'un repas";
        $this->update_title = "Mise à jour d'un repas";
        $this->delete_title = "Suppression d'un repas";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce repas ";
    }
        
}
    