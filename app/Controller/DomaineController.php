<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class DomaineController extends AppController
{
    use TraitCRUDController;
   
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::DOMAINE;
        $this->folder_view_index = 'domaine.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'domaine';
        $this->class_name = 'Domaine';

        $this->title_page = 'Gestion des domaines - Ges-School';
        $this->title_home = 'Gestion des domaines';
        $this->create_title = "Creation d'un domaine";
        $this->view_title = "Information d'un domaine";
        $this->update_title = "Mise à jour d'un domaine";
        $this->delete_title = "Suppression d'un domaine";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce domaine ";
    }

}
