<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Model\DBTable;
use App\Controller\Admin\AppController;

class PaysController extends AppController
{
    
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::PAYS;
        $this->folder_view_index = 'pays.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'pays';
        $this->class_name = 'pays';

        $this->title_page = 'Gestion des pays - Ges-School';
        $this->title_home = 'Gestion des pays';
        $this->create_title = "Création d'un pays";
        $this->view_title = "Information d'un pays";
        $this->update_title = "Mise à jour d'un pays";
        $this->delete_title = "Suppression d'un pays";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce pays? ";
        
    }



        
}
    