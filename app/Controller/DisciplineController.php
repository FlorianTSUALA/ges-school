<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class DisciplineController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = 'discipline';
        $this->folder_view_index = 'discipline.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'discipline';
        $this->class_name = 'Discipline';

        $this->title_page = 'Gestion des disciplines - Ges-School';
        $this->title_home = 'Gestion des disciplines';
        $this->create_title = "Creation d'une discipline";
        $this->view_title = "Information d'une discipline";
        $this->update_title = "Mise à jour d'une discipline";
        $this->delete_title = "Suppression d'une discipline";
        $this->msg_delete = "Voulez-vous vraiment supprimer cette discipline ";
    }

}
