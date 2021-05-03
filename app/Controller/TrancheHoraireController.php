<?php

namespace App\Controller;
    
use App\Model\DBTable;
use App\Controller\Admin\AppController;

class TrancheHoraireController extends AppController
{

        
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::TRANCHE_HORAIRE;
        $this->folder_view_index = 'tranche_horaire.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'tranche_horaire';
        $this->class_name = 'tranche_horaire';

        $this->title_page = 'Gestion des tranches horaires - Ges-School';
        $this->title_home = 'Gestion des tranches horaires';
        $this->create_title = "Creation d'une tranche horaire";
        $this->view_title = "Information d'une tranche horaire";
        $this->update_title = "Mise à jour d'une tranche horaire";
        $this->delete_title = "Suppression d'une tranche horaire";
        $this->msg_delete = "Voulez-vous vraiment supprimer la tranche horaire ";
    }

    

}
