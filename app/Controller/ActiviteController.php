<?php

namespace App\Controller;

use App\Model\Activite;
use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class ActiviteController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::ACTIVITE;
        $this->folder_view_index = 'activite.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'activite';
        $this->class_name = 'Activite';

        $this->title_page = 'Gestion des activites - Ges-School';
        $this->title_home = 'Gestion des activites';
        $this->create_title = "Creation d'une activite";
        $this->view_title = "Information d'une activite";
        $this->update_title = "Mise à jour d'une activite";
        $this->delete_title = "Suppression d'une activite";
        $this->msg_delete = "Voulez-vous vraiment supprimer la activite ";
    }
        
    public function getall(){
        $model = Activite::table();
        $results = $model->select(' type_activite.libelle as type_activite_id, type_activite.code as external_target, activite.code as code, activite.libelle as libelle, activite.description as description, montant')
                    ->where('activite.visibilite', 1)
                    ->join('type_activite', 'activite.type_activite_id', '=', 'type_activite.id')->get();
        return $results;
    }

}
