<?php

namespace App\Controller;
    
use App\Model\DBTable;
use Core\Session\Request;
use App\Controller\Admin\AppController;

class StatutApprenantController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('statut_apprenant');

        $this->vairant = DBTable::STATUT_APPRENANT;
        $this->folder_view_index = 'statut_apprenant.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'statut_apprenant';
        $this->class_name = 'statut_apprenant';

        $this->title_page = 'Gestion des statuts apprenants - Ges-School';
        $this->title_home = 'Gestion des statuts apprenants';
        $this->create_title = "Creation d'un statut apprenant";
        $this->view_title = "Information d'un statut apprenant";
        $this->update_title = "Mise à jour d'un statut apprenant";
        $this->delete_title = "Suppression d'un statut apprenant";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce statut apprenant ";
    }
    

}