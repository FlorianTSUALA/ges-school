<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class TypeActiviteController extends AppController
{
    use TraitCRUDController;
   
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::TYPE_ACTIVITE;
        $this->folder_view_index = 'type_activite.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'type_activite';
        $this->class_name = 'type_activite';

        $this->title_page = 'Gestion des types d\'activités - Ges-School';
        $this->title_home = 'Gestion des types d\'activités';
        $this->create_title = "Creation d'un type d\'activités";
        $this->view_title = "Information d'un type d\'activités";
        $this->update_title = "Mise à jour d'un type d\'activités";
        $this->delete_title = "Suppression d'un type d\'activités";
        $this->msg_delete = "Voulez-vous vraiment supprimer le type d\'activité";
    }

}
