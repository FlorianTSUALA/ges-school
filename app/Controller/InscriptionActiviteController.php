<?php

namespace App\Controller;

use App\Model\Inscription_activite;
use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Model\InscriptionActivite;
use ClanCats\Hydrahon\Query\Expression as Ex;
use App\Controller\Admin\AppController;

class InscriptionActiviteController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::INSCRIPTION_ACTIVITE;
        $this->folder_view_index = 'inscription_activite.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'inscription_activite';
        $this->class_name = 'Inscription_activite';

        $this->title_page = 'Gestion des inscription_activites - Ges-School';
        $this->title_home = 'Gestion des inscription_activites';
        $this->create_title = "Creation d'une inscription_activite";
        $this->view_title = "Information d'une inscription_activite";
        $this->update_title = "Mise à jour d'une inscription_activite";
        $this->delete_title = "Suppression d'une inscription_activite";
        $this->msg_delete = "Voulez-vous vraiment supprimer la inscription_activite ";
    }

        
    public function getall(){
        $model = InscriptionActivite::table();
        $results = $model->select([
            new Ex("concat(eleve.nom,' ',eleve.prenom) as libelle"),
            'eleve.code as eleve_code', 
            'personnel_activite.libelle as personnel_activite_id',
            'personnel_activite.code as personnel_activite_code', 
            'inscription_activite.code as code', 
            'inscription_activite.libelle as libelle', 
            'inscription_activite.description as description',
            'inscription_activite.montant as montant'])
            ->where('inscription_activite.visibilite', 1)
            ->join('eleve', 'inscription_activite.personnel_activite_id', '=', 'eleve.id')
            ->join('personnel_activite', 'inscription_activite.personnel_activite_id', '=', 'personnel_activite.id')
            ->get();
        return $results;
    }

}
