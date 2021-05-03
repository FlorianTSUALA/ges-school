<?php

namespace App\Controller;

use App\Model\Matiere;
use App\Helpers\Helpers;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class MatiereController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = 'matiere';
        $this->folder_view_index = 'matiere.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'matiere';
        $this->class_name = 'Matiere';

        $this->title_page = 'Gestion des matieres - Ges-School';
        $this->title_home = 'Gestion des matieres';
        $this->create_title = "Creation d'une matiere";
        $this->view_title = "Information d'une matiere";
        $this->update_title = "Mise à jour d'une matiere";
        $this->delete_title = "Suppression d'une matiere";
        $this->msg_delete = "Voulez-vous vraiment supprimer cette matiere ";
    }

    
    public function getall(){
        $model = Matiere::table();
        $results = $model->select('
                discipline.libelle as discipline_id, 
                discipline.code as external_target,
                matiere.code as code, 
                matiere.libelle as libelle, 
                matiere.abreviation as abreviation, 
                matiere.couleur as couleur, 
                matiere.description as description
                ')
                    ->where('matiere.visibilite','=', 1)
                    ->join('discipline', 'matiere.discipline_id', '=', 'discipline.id')
                    ->get();
        return $results;
    }

    public function getApiAllEssentiel()  
    {
        $Matieres = Helpers::toJSON(Matiere::table()->select([ 'id' => 'id' , 'libelle' => 'value' ])->where('visibilite', 1)->get());
        $this->sendResponseAndExit(Helpers::toJSON($Matieres, TRUE));
    }
}
