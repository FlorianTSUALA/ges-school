<?php

namespace App\Controller;
    
use App\Model\DBTable;
use Core\Session\Request;
use App\Controller\Admin\AppController;

class StatutEleveController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('statut_eleve');

        $this->vairant = DBTable::STATUT_ELEVE;
        $this->folder_view_index = 'statut_eleve.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'statut_eleve';
        $this->class_name = 'statut_eleve';

        $this->title_page = 'Gestion des statuts eleves - Ges-School';
        $this->title_home = 'Gestion des statuts eleves';
        $this->create_title = "Creation d'un statut eleve";
        $this->view_title = "Information d'un statut eleve";
        $this->update_title = "Mise à jour d'un statut eleve";
        $this->delete_title = "Suppression d'un statut eleve";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce statut eleve ";
    }
    

}