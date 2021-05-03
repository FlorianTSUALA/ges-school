<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class CycleController extends AppController
{
    use TraitCRUDController;
   
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::CYCLE;
        $this->folder_view_index = 'cycle.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'cycle';
        $this->class_name = 'Cycle';

        $this->title_page = 'Gestion des cycles - Ges-School';
        $this->title_home = 'Gestion des cycles';
        $this->create_title = "Creation d'un cycle";
        $this->view_title = "Information d'un cycle";
        $this->update_title = "Mise à jour d'un cycle";
        $this->delete_title = "Suppression d'un cycle";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce cycle ";
    }

}
