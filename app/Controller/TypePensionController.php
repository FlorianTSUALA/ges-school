<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class TypePensionController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = 'type_pension';
        $this->folder_view_index = 'type_pension.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'type_pension';
        $this->class_name = 'TypePension';

        $this->title_page = 'Gestion des types de pensions - Ges-School';
        $this->title_home = 'Gestion des types de pensions';
        $this->create_title = "Creation d'un type de pensions";
        $this->view_title = "Information d'un type de pensions";
        $this->update_title = "Mise à jour d'un type de pensions";
        $this->delete_title = "Suppression d'un type de pensions";
        $this->msg_delete = "Voulez-vous vraiment supprimer d'un type de pensions ";
    }

}
