<?php

namespace App\Controller;

use App\Model\Classe;
use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class ClasseController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::CLASSE;
        $this->folder_view_index = 'classe.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'classe';
        $this->class_name = 'Classe';

        $this->title_page = 'Gestion des classes - Ges-School';
        $this->title_home = 'Gestion des classes';
        $this->create_title = "Creation d'une classe";
        $this->view_title = "Information d'une classe";
        $this->update_title = "Mise à jour d'une classe";
        $this->delete_title = "Suppression d'une classe";
        $this->msg_delete = "Voulez-vous vraiment supprimer la classe ";
    }

        
    public function getall(){
        $model = Classe::table();
        $results = $model->select(' cycle.libelle as cycle_id, cycle.code as external_target, classe.code as code, classe.libelle as libelle, classe.description as description')
                    ->where('classe.visibilite', 1)
                    ->join('cycle', 'classe.cycle_id', '=', 'cycle.id')->get();
        return $results;
    }

}
