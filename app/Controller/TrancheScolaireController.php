<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Model\TrancheScolaire;
use App\Controller\Admin\AppController;

class TrancheScolaireController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::TRANCHE_SCOLAIRE;
        $this->folder_view_index = 'tranche_scolaire.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'tranche_scolaire';
        $this->class_name = 'tranche_scolaire';

        $this->title_page = 'Gestion des tranches scolaire - Ges-School';
        $this->title_home = 'Gestion des tranches scolaire';
        $this->create_title = "Creation d'une tranche scolaire";
        $this->view_title = "Information d'une tranche scolaire";
        $this->update_title = "Mise à jour d'une tranche scolaire";
        $this->delete_title = "Suppression d'une tranche scolaire";
        $this->msg_delete = "Voulez-vous vraiment supprimer la tranche scolaire ";
    }

    public function getall(){
        $model = TrancheScolaire::table();
        // annee_scolaire.code as external_target, 
        $results = $model->select('
                annee_scolaire.libelle as annee_scolaire_id, 
                tranche_scolaire.code as code, 
                tranche_scolaire.libelle as libelle, 
                tranche_scolaire.date_fin as date_fin
                ')
                    ->where('tranche_scolaire.visibilite', 1)
                    ->join('annee_scolaire', 'tranche_scolaire.annee_scolaire_id', '=', 'annee_scolaire.id')->get();
        return $results;
    }


}