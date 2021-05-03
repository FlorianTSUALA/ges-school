<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Model\DBTable;
use App\Controller\Admin\AppController;

//TO DEL
class AffectationClasseMatiereController extends AppController
{
    
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::AFFECTATION_CLASSE_MATIERE;
        $this->folder_view_index = 'affectation_classe_matiere.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'affectation_classe_matiere';
        $this->class_name = 'AffectationClasseMatiere';

        $this->title_page = 'Gestion des affectation classe matiàre - Ges-School';
        $this->title_home = 'Gestion des affectation classe matiàre';
        $this->create_title = "affectation classe matiàre";
        $this->view_title = "Information des affectations classe matiàre";
        $this->update_title = "Mise à jour d'un champs";
        $this->delete_title = "Suppression d'un champs";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce champs? ";
        
    }
        
}
    