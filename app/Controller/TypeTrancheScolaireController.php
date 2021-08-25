<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Model\DBTable;
use App\Controller\Admin\AppController;

class TypeTrancheScolaireController extends AppController
{
    
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::TYPE_TRANCHE_SCOLAIRE;
        $this->folder_view_index = 'type_tranche_scolaire.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'type_tranche_scolaire';
        $this->class_name = 'type_tranche_scolaire';

        $this->title_page = 'Gestion des types de tranche_scolaire - Ges-School';
        $this->title_home = 'Gestion des types de tranche_scolaire';
        $this->create_title = "Création d'un type tranche_scolaire";
        $this->view_title = "Information d'un type tranche scolaire";
        $this->update_title = "Mise à jour d'un type tranche scolaire";
        $this->delete_title = "Suppression d'un type tranche scolaire";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce type de tranche scolaire? ";
        
    }



        
}
    